<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CepController extends Controller
{
    private const UF_FILTRO = 'SC';

    public function index(Request $request)
    {
        // TESTE: Pegando CEP + Endereço.
        // Sem ordenação (orderBy) para performance máxima.
        // distinct() para evitar repetições exatas.
        $ceps = Estabelecimento::select('cep', 'municipio')
            ->where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2) // Apenas ativas
            ->with('municipioRel:codigo,descricao') // Traz o nome da cidade
            ->distinct()
            ->get();

        return view('pages.ceps.index', [
            'ceps' => $ceps
        ]);
    }

    public function show($cep)
    {
        // Limpa o CEP da URL
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);

        // Busca informações do CEP (pega o primeiro registro para ter o endereço)
        $dadosCep = Estabelecimento::where('cep', $cepLimpo)
            ->where('uf', self::UF_FILTRO)
            ->with('municipioRel')
            ->select('cep', 'tipo_logradouro', 'logradouro', 'bairro', 'municipio', 'uf')
            ->first();

        if (!$dadosCep) {
            return redirect()->route('ceps.index')->with('error', 'CEP não encontrado ou sem empresas ativas.');
        }

        // Busca as empresas deste CEP
        $empresas = Estabelecimento::where('cep', $cepLimpo)
            ->where('uf', self::UF_FILTRO)
            ->where('situacao_cadastral', 2)
            ->with('empresa:cnpj_basico,razao_social,capital_social')
            ->orderByDesc('data_inicio_atividade')
            ->paginate(50);

        return view('pages.ceps.show', [
            'dadosCep' => $dadosCep,
            'empresas' => $empresas,
            'cepFormatado' => $this->formatarCep($cepLimpo)
        ]);
    }

    private function formatarCep($cep)
    {
        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }
}