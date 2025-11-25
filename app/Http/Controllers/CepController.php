<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CepController extends Controller
{
    private const UF_FILTRO = 'SC';

    public function index(Request $request)
    {
        $ceps = Estabelecimento::select('cep', 'municipio', DB::raw('COUNT(*) as total_empresas'))
            ->where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->whereNotNull('cep')
            ->with('municipioRel:codigo,descricao')
            ->groupBy('cep', 'municipio')
            ->orderByDesc('total_empresas')
            ->paginate(60);

        $totalCeps = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->whereNotNull('cep')
            ->distinct('cep')
            ->count('cep');

        $totalEmpresasEstado = Estabelecimento::where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->whereNotNull('cep')
            ->count();

        return view('pages.ceps.index', [
            'ceps' => $ceps,
            'totalCeps' => $totalCeps,
            'totalEmpresasEstado' => $totalEmpresasEstado,
        ]);
    }

    public function show($cep)
    {
        // Limpa o CEP da URL
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cepLimpo) !== 8) {
            return redirect()->route('ceps.index')->with('error', 'CEP inválido. Utilize 8 dígitos.');
        }

        // Busca informações do CEP (pega o primeiro registro para ter o endereço)
        $dadosCep = Estabelecimento::where('cep', $cepLimpo)
            ->where('uf', self::UF_FILTRO)
            ->whereNotNull('cep')
            ->with('municipioRel')
            ->select('cep', 'tipo_logradouro', 'logradouro', 'bairro', 'municipio', 'uf')
            ->first();

        if (!$dadosCep) {
            return redirect()->route('ceps.index')->with('error', 'CEP não encontrado ou sem empresas ativas.');
        }

        // Métricas para SEO e apresentação
        $totalEmpresas = Estabelecimento::where('cep', $cepLimpo)
            ->where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->whereNotNull('cep')
            ->count();

        $topCnaes = Estabelecimento::where('cep', $cepLimpo)
            ->where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->whereNotNull('cep')
            ->select('cnae_fiscal', DB::raw('COUNT(*) as total'))
            ->groupBy('cnae_fiscal')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $capitalSocialTotal = Estabelecimento::where('estabelecimentos.cep', $cepLimpo)
            ->where('estabelecimentos.uf', self::UF_FILTRO)
            ->where('estabelecimentos.situacao_cadastral', 2)
            ->whereNotNull('estabelecimentos.cep')
            ->join('empresas', 'empresas.cnpj_basico', '=', 'estabelecimentos.cnpj_basico')
            ->sum('empresas.capital_social');

        // Busca as empresas deste CEP
        $empresas = Estabelecimento::where('cep', $cepLimpo)
            ->where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->whereNotNull('cep')
            ->with([
                'empresa:cnpj_basico,razao_social,capital_social',
                'municipioRel:codigo,descricao',
            ])
            ->orderByDesc('data_inicio_atividade')
            ->paginate(50);

        return view('pages.ceps.show', [
            'dadosCep' => $dadosCep,
            'empresas' => $empresas,
            'topCnaes' => $topCnaes,
            'capitalSocialTotal' => $capitalSocialTotal,
            'totalEmpresas' => $totalEmpresas,
            'cepFormatado' => $this->formatarCep($cepLimpo),
        ]);
    }

    private function formatarCep($cep)
    {
        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }
}