<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CepController extends Controller
{
    private const UF_FILTRO = 'SC';

    // INDEX: EXIBE LISTA DE CEPS E METADADOS
    public function index(Request $request)
    {
        // BUSCA OS CEPS EM DESTAQUE (TOP 12 COM MAIOR NÚMERO DE EMPRESAS) E CACHEIA POR 3 MESES
        $cepsDestaque = Cache::remember('ceps_destaque_v2', now()->addMonths(3), function () {
            return Estabelecimento::select('cep', 'municipio', DB::raw('COUNT(*) as total_empresas'))
                ->where('uf', self::UF_FILTRO)
                ->where('situacao_cadastral', 2)
                ->whereNotNull('cep')
                ->with('municipioRel:codigo,descricao')
                ->groupBy('cep', 'municipio')
                ->orderByDesc('total_empresas')
                ->take(48)
                ->get();
        });

        // TOTAL DE CEPS DISTINTOS NO ESTADO COM EMPRESAS ATIVAS (CACHEIA POR 3 MESES)
        $totalCeps = Cache::remember('total_ceps', now()->addMonths(3), function () {
            return Estabelecimento::where('uf', self::UF_FILTRO)
                ->where('situacao_cadastral', 2)
                ->whereNotNull('cep')
                ->distinct('cep')
                ->count('cep');
        });

        // TOTAL DE EMPRESAS NO ESTADO COM CEPS CADASTRADOS (CACHEIA POR 3 MESES)
        $totalEmpresasEstado = Cache::remember('total_empresas_estado', now()->addMonths(3), function () {
            return Estabelecimento::where('uf', self::UF_FILTRO)
                ->where('situacao_cadastral', 2)
                ->whereNotNull('cep')
                ->count();
        });

        return view('pages.ceps.index', [
            'cepsDestaque'        => $cepsDestaque,
            'totalCeps'           => $totalCeps,
            'totalEmpresasEstado' => $totalEmpresasEstado,
        ]);
    }

    public function show($cep)
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
        if (strlen($cepLimpo) !== 8) {
            return redirect()->route('ceps.index')->with('error', 'CEP inválido. Utilize 8 dígitos.');
        }

        $dadosCep = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->where('cep', $cepLimpo)
            ->with('municipioRel')
            ->select('cep', 'tipo_logradouro', 'logradouro', 'bairro', 'municipio', 'uf')
            ->first();

        if (!$dadosCep) {
            return redirect()->route('ceps.index')->with('error', 'CEP não encontrado ou sem empresas ativas.');
        }

        $totalEmpresas = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->where('cep', $cepLimpo)
            ->count();

        // Top 6 CNAEs (join com cnaes para pegar descrição)
        $topCnaes = Estabelecimento::where('estabelecimentos.uf', self::UF_FILTRO)
            ->where('estabelecimentos.situacao_cadastral', 2)
            ->where('estabelecimentos.cep', $cepLimpo)
            ->leftJoin('cnaes as c', 'estabelecimentos.cnae_fiscal_principal', '=', 'c.codigo')
            ->select(
                'estabelecimentos.cnae_fiscal_principal',
                DB::raw('COUNT(*) as total'),
                DB::raw('COALESCE(c.descricao, "Descrição não informada") as descricao')
            )
            ->groupBy('estabelecimentos.cnae_fiscal_principal', 'c.descricao')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // Não calculamos mais a soma do capital social
        $empresas = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->where('cep', $cepLimpo)
            ->with([
                'empresa:cnpj_basico,razao_social,capital_social',
                'municipioRel:codigo,descricao',
            ])
            ->paginate(50);

        return view('pages.ceps.show', [
            'dadosCep'      => $dadosCep,
            'empresas'      => $empresas,
            'topCnaes'      => $topCnaes,
            'totalEmpresas' => $totalEmpresas,
            'cepFormatado'  => $this->formatarCep($cepLimpo),
        ]);
    }

    /**
     * Busca dinâmica de CEPs
     *
     * Esta função é utilizada pelo campo de busca da página de CEPs para
     * retornar sugestões em tempo real. Ela limpa a entrada para manter
     * apenas dígitos, exige pelo menos dois caracteres para iniciar a
     * busca e retorna um JSON com o CEP, município e o total de empresas.
     */
    public function search(Request $request)
    {
        $query = preg_replace('/[^0-9]/', '', $request->input('q', $request->input('cep', '')));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Agora fazemos join com municipios.descricao para exibir o nome da cidade
        $resultados = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->where('cep', 'like', $query . '%')
            ->leftJoin('municipios', 'estabelecimentos.municipio', '=', 'municipios.codigo')
            ->select(
                'estabelecimentos.cep as cep',
                DB::raw('COALESCE(municipios.descricao, "") as municipio'),
                DB::raw('COUNT(*) as total_empresas')
            )
            ->groupBy('estabelecimentos.cep', 'municipios.descricao')
            ->orderByDesc('total_empresas')
            ->take(10)
            ->get();

        return response()->json($resultados);
    }


    private function formatarCep($cep)
    {
        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }
}