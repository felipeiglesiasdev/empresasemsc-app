<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MunicipioController extends Controller
{
    private const UF_FILTRO = 'SC';

    public function index(Request $request)
    {
        // Recupera os parâmetros de filtro
        $search = $request->input('search');
        $letra = $request->input('letra');

        // Cacheia a lista base de municípios de SC com contagem de empresas ativas
        // Cache longo (1 dia) pois a criação/fechamento de empresas não muda drasticamente a ordem em minutos
        $todosMunicipios = Cache::remember('lista_municipios_sc_completa', now()->addDay(), function () {
            return Municipio::join('estabelecimentos', 'municipios.codigo', '=', 'estabelecimentos.municipio')
                ->select('municipios.codigo', 'municipios.descricao', DB::raw('count(estabelecimentos.cnpj_basico) as total_empresas'))
                ->where('estabelecimentos.uf', self::UF_FILTRO)
                ->where('estabelecimentos.situacao_cadastral', 2) // Apenas ativas
                ->groupBy('municipios.codigo', 'municipios.descricao')
                ->orderBy('municipios.descricao')
                ->get();
        });

        // Aplica os filtros na Coleção (muito mais rápido que no DB para ~300 registros)
        $municipiosFiltrados = $todosMunicipios;

        if ($search) {
            $municipiosFiltrados = $municipiosFiltrados->filter(function ($municipio) use ($search) {
                // Busca insensível a acentos e caixa (stripos simples)
                return Str::contains(Str::lower($municipio->descricao), Str::lower($search));
            });
        }

        if ($letra) {
            $municipiosFiltrados = $municipiosFiltrados->filter(function ($municipio) use ($letra) {
                return Str::startsWith($municipio->descricao, strtoupper($letra));
            });
        }

        return view('pages.municipios.index', [
            'municipios' => $municipiosFiltrados,
            'filtroLetra' => $letra,
            'busca' => $search,
            'totalMunicipios' => $todosMunicipios->count(),
            'totalEmpresasEstado' => $todosMunicipios->sum('total_empresas')
        ]);
    }

    /**
     * Exibe a página de um município específico buscando pelo SLUG.
     */
    public function show($slug)
    {
        $municipio = Cache::remember("municipio_slug_obj_{$slug}", now()->addDay(), function () use ($slug) {
            $todos = Municipio::select('codigo', 'descricao')->get();
            return $todos->first(function ($m) use ($slug) {
                return Str::slug($m->descricao) === $slug;
            });
        });

        if (!$municipio) {
            abort(404, 'Município não encontrado');
        }

        $id = $municipio->codigo;

        // ALTERAÇÃO: De simplePaginate para paginate para mostrar os números (1, 2, 3...)
        $empresas = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->where('municipio', $id)
            ->with('empresa:cnpj_basico,razao_social,capital_social')
            ->select('cnpj_basico', 'cnpj_ordem', 'cnpj_dv', 'nome_fantasia', 'cep', 'logradouro', 'numero', 'bairro', 'data_inicio_atividade')
            ->orderByDesc('data_inicio_atividade')
            ->paginate(50); // Paginação completa

        $totalEmpresas = Cache::remember("municipio_total_empresas_{$id}", now()->addDay(), function () use ($id) {
            return Estabelecimento::where('uf', self::UF_FILTRO)
                ->where('situacao_cadastral', 2)
                ->where('municipio', $id)
                ->count();
        });

        return view('pages.municipios.show', [
            'municipio' => $municipio,
            'empresas' => $empresas,
            'totalEmpresas' => $totalEmpresas
        ]);
    }
}