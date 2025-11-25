<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Estabelecimento;
use App\Models\Cnae;
use App\Models\Municipio; // Importar o Model Município
use Carbon\Carbon;

class HomeController extends Controller
{
    // Definimos o estado (UF) que será o filtro principal do site
    private const UF_FILTRO = 'SC';

    // PÁGINA INICIAL
    public function home() { 
        $hoje = Carbon::now();
        $inicioAno = $hoje->copy()->startOfYear()->toDateString();
        $hojeFormatado = $hoje->toDateString();
        $uf = self::UF_FILTRO;

        // 1. BALANÇO DE EMPRESAS ABERTAS VS ENCERRADAS/INATIVAS EM SC
        $balancoAnoAtualSC = Cache::remember('home_balanco_ano_sc', now()->addDay(), function () use ($inicioAno, $hojeFormatado, $uf) {
            $abertas = Estabelecimento::where('uf', $uf)
                ->whereBetween('data_inicio_atividade', [$inicioAno, $hojeFormatado])
                ->count();
            
            // Situação cadastral 2 = ATIVA. != 2 = Baixada, Suspensa, Inapta, Nula
            $encerradasInativas = Estabelecimento::where('uf', $uf)
                ->where('situacao_cadastral', '!=', 2)
                ->whereBetween('data_situacao_cadastral', [$inicioAno, $hojeFormatado])
                ->count();
            
            return ['abertas' => $abertas, 'encerradas_inativas' => $encerradasInativas];
        });

        // 2. TOTAL DE EMPRESAS POR SITUAÇÃO CADASTRAL EM SC
        $totalPorSituacaoSC = Cache::remember('home_total_por_situacao_sc', now()->addDay(), function () use ($uf) {
            return Estabelecimento::where('uf', $uf)
                ->select('situacao_cadastral', DB::raw('count(*) as total'))
                ->groupBy('situacao_cadastral')
                ->pluck('total', 'situacao_cadastral'); 
        });

        $situacaoNomes = [
            // 1 => 'Nula', // Geralmente irrelevante
            2 => 'Ativas',
            3 => 'Suspensas',
            4 => 'Inaptas', 
            8 => 'Baixadas'
        ];

        $statsSituacaoSC = collect($situacaoNomes)->mapWithKeys(function($nome, $codigo) use ($totalPorSituacaoSC) {
            return [$nome => $totalPorSituacaoSC[$codigo] ?? 0];
        });

        // 3. TOP 5 ATIVIDADES EM SC (Empresas Ativas)
        $top5AtividadesSC = Cache::remember('home_top_5_atividades_sc', now()->addDay(), function () use ($uf) {
             return Estabelecimento::join('cnaes as c', 'estabelecimentos.cnae_fiscal_principal', '=', 'c.codigo')
                ->select('c.descricao', DB::raw('COUNT(*) as total'))
                ->where('estabelecimentos.uf', $uf)
                ->where('estabelecimentos.situacao_cadastral', 2) // Apenas ativas
                ->groupBy('c.descricao')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        });

        // 4. [NOVA IDEIA] TOTAL DE EMPRESAS ATIVAS EM SC
        $totalAtivasSC = Cache::remember('home_total_ativas_sc', now()->addDay(), function () use ($uf) {
            return Estabelecimento::where('uf', $uf)
                ->where('situacao_cadastral', 2)
                ->count();
        });

        // 5. TOP 10 CIDADES COM MAIS EMPRESAS ATIVAS (NOVO)
        $top10CidadesSC = Cache::remember('home_top_10_cidades_sc', now()->addDay(), function () use ($uf) {
            return Estabelecimento::join('municipios as m', 'estabelecimentos.municipio', '=', 'm.codigo')
                ->select('m.descricao', DB::raw('COUNT(*) as total'))
                ->where('estabelecimentos.uf', $uf)
                ->where('estabelecimentos.situacao_cadastral', 2) // Apenas ativas
                ->groupBy('m.descricao')
                ->orderByDesc('total')
                ->limit(10) // Retornando apenas 10
                ->get();
        });

        // 5. CEPs DESTAQUE (Joinville, Floripa, Blumenau)
        // Cache: v3
        $randomCepsSC = Cache::remember('home_ceps_destaque_v4', now()->addDay(), function () use ($uf) {
            // Busca os códigos das cidades alvo
            $codigosCidades = Municipio::where(function($q) {
                $q->where('descricao', '=', 'JOINVILLE')
                  ->orWhere('descricao', '=', 'FLORIANOPOLIS') 
                  ->orWhere('descricao', '=', 'BLUMENAU');
            })->pluck('codigo');

            $cepsSelecionados = collect();

            // Para cada cidade, tentamos pegar 2 CEPs aleatórios
            foreach ($codigosCidades as $codigoCidade) {
                // 1. Pega CEPs candidatos dessa cidade (ativos)
                $candidatos = Estabelecimento::select('cep')
                    ->where('uf', $uf)
                    ->where('situacao_cadastral', 2)
                    ->where('municipio', $codigoCidade)
                    ->inRandomOrder()
                    ->limit(10) // Amostra maior para garantir variedade
                    ->pluck('cep')
                    ->unique()
                    ->take(2); // Pega apenas 2

                // 2. Para cada CEP escolhido, pega os detalhes e CONTA o total
                foreach ($candidatos as $cep) {
                    $dados = Estabelecimento::select('cep', 'tipo_logradouro', 'logradouro', 'bairro', 'municipio', 'uf')
                        ->where('cep', $cep)
                        ->where('situacao_cadastral', 2)
                        ->with('municipioRel:codigo,descricao')
                        ->first();
                    
                    if ($dados) {
                        // Contagem REAL de empresas neste CEP
                        $dados->total_empresas = Estabelecimento::where('cep', $cep)
                            ->where('situacao_cadastral', 2)
                            ->count();
                        
                        $cepsSelecionados->push($dados);
                    }
                }
            }

            // Caso falhe a busca específica (banco vazio/teste), fallback genérico
            if ($cepsSelecionados->isEmpty()) {
                return Estabelecimento::select('cep', 'tipo_logradouro', 'logradouro', 'bairro', 'municipio', 'uf')
                    ->where('uf', $uf)
                    ->where('situacao_cadastral', 2)
                    ->with('municipioRel:codigo,descricao')
                    ->inRandomOrder()
                    ->limit(6)
                    ->get()
                    ->map(function($item) {
                        $item->total_empresas = Estabelecimento::where('cep', $item->cep)->where('situacao_cadastral', 2)->count();
                        return $item;
                    });
            }

            return $cepsSelecionados->take(6);
        });

        return view('pages.home', [
            'balancoSC' => $balancoAnoAtualSC,
            'statsSituacaoSC' => $statsSituacaoSC,
            'totalAtivasSC' => $totalAtivasSC,
            'top10CidadesSC' => $top10CidadesSC,
            'randomCepsSC' => $randomCepsSC, // Passando para a view
            'anoAtual' => $hoje->year,
        ]);
    }
    
}