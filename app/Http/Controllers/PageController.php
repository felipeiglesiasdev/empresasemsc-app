<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Estabelecimento;
use App\Models\Cnae;
use Carbon\Carbon;
class PageController extends Controller
{
    // PÁGINA INICIAL
    public function home() { 
        // 1. BALANÇO DE EMPRESAS ABERTAS EM 2025 VS ENCERRADAS/INATIVAS EM 2025
        $balanco2025 = Cache::remember('home_balanco_2025', now()->addMonths(2), function () {
            $hoje = Carbon::now()->toDateString();
            $inicioAno = Carbon::now()->startOfYear()->toDateString(); // '2025-01-01'
            $abertas = Estabelecimento::whereBetween('data_inicio_atividade', [$inicioAno, $hoje])->count();
            // Usando != 2 (ENCERRADAS) 
            $encerradasInativas = Estabelecimento::where('situacao_cadastral', '!=', 2)->whereBetween('data_situacao_cadastral', [$inicioAno, $hoje])->count();
            return ['abertas' => $abertas, 'encerradas_inativas' => $encerradasInativas];
        });
        // 2. TOTAL DE EMPRESAS POR SITUAÇÃO CADASTRAL
        $totalPorSituacao = Cache::remember('home_total_por_situacao', now()->addMonths(2), function () {
            // Códigos: 1-NULA, 2-ATIVA, 3-SUSPENSA, 4-INAPTA (BAIXADA), 8-BAIXADA
            return Estabelecimento::select('situacao_cadastral', DB::raw('count(*) as total'))
                ->groupBy('situacao_cadastral')
                ->pluck('total', 'situacao_cadastral'); 
        });
        // MAPA DE CÓDIGOS
        $situacaoNomes = [
            1 => 'Nula',
            2 => 'Ativa',
            3 => 'Suspensa',
            4 => 'Inapta', 
            8 => 'Baixada'  
        ];
        $statsSituacao = collect($situacaoNomes)->mapWithKeys(function($nome, $codigo) use ($totalPorSituacao) {
            return [$nome => $totalPorSituacao[$codigo] ?? 0];
        });
        // 3. TOP 3 MAIORES ATIVIDADES 
        $top3AtividadesBrasil = Cache::remember('home_top_3_atividades_brasil', now()->addMonths(2), function () {
             return Estabelecimento::join('cnaes as c', 'estabelecimentos.cnae_fiscal_principal', '=', 'c.codigo')
                ->select('estabelecimentos.cnae_fiscal_principal as codigo','c.descricao',DB::raw('COUNT(*) as total'))
                ->where('estabelecimentos.situacao_cadastral', 2)
                ->groupBy('estabelecimentos.cnae_fiscal_principal', 'c.descricao')
                ->orderByDesc('total')->limit(3)->get();
        });
        return view('pages.home', [
            'balanco2025' => $balanco2025,
            'statsSituacao' => $statsSituacao,
            'top3AtividadesBrasil' => $top3AtividadesBrasil
        ]);
    }
    // PÁGINA DE CONSULTAR CNPJ
    public function consultarCnpj() { return view('pages.consultar-cnpj'); }
    // PÁGINA DE CONSULTAR CNAE
    public function consultarCnae()
    {
        // Busca todos os CNAEs (1359 registros é rápido)
        $cnaes = Cnae::query()->select(['codigo', 'descricao'])->get();
        
        // Envia os dados para a view
        return view('pages.consultar-cnae', [
            'cnaes' => $cnaes
        ]);
    }
    // PÁGINA DE CONSULTAR CEP
    public function consultarCep() { return view('pages.consultar-cep'); }
    // PÁGINA DE SERVIÇOS
    public function nossosServicos() { return view('pages.nossos-servicos'); }
    // PÁGINA DE POLÍTICA DE PRIVACIDADE
    public function politicaDePrivacidade() { return view('pages.politica-de-privacidade'); }
}


