<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Estabelecimento; 
use App\Models\Cnae;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CnpjController extends Controller
{

    private function findValidEstabelecimento(string $cnpj): ?Estabelecimento 
    {
        $cnpjBase = substr($cnpj, 0, 8);
        $cnpjOrdem = substr($cnpj, 8, 4);
        $cnpjDv = substr($cnpj, 12, 2);
        $estabelecimento = Estabelecimento::where('cnpj_basico', $cnpjBase)->where('cnpj_ordem', $cnpjOrdem)->where('cnpj_dv', $cnpjDv)->first();
        return $estabelecimento; 
    }
    //################################################################################################
    //################################################################################################
    // Processa o formulário de consulta.
    // Se encontrar, redireciona. Se não, volta com erro para o popup.
    public function consultar(Request $request): RedirectResponse
    {
        $request->validate(['cnpj' => 'required|string|max:18'], [
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cnpj.string' => 'O CNPJ deve ser um texto.',
            'cnpj.max' => 'O CNPJ não pode ter mais que 18 caracteres.',
        ]);
        $cnpjLimpo = preg_replace('/[^0-9]/', '', $request->input('cnpj'));
        if (strlen($cnpjLimpo) !== 14) {
            return redirect()->back()->withInput($request->only('cnpj'))->with('error', 'CNPJ inválido. Por favor, digite os 14 números do CNPJ.');
        }
        $estabelecimento = $this->findValidEstabelecimento($cnpjLimpo);
        // Se encontrou o estabelecimento...
        if ($estabelecimento) {
            // Pega a empresa relacionada (já deve estar carregada ou será lazy loaded)
            $empresa = $estabelecimento->empresa()->first(); // Garante que temos o objeto Empresa
            return redirect()->route('cnpj.show', ['cnpj' => $cnpjLimpo])
                             ->with([
                                 'found_estabelecimento' => $estabelecimento,
                                 'found_empresa' => $empresa 
                             ]);
        } 
        // Se não encontrou...
        else {
            return redirect()->back()
                             ->withInput($request->only('cnpj')) 
                             ->with('error', 'CNPJ não encontrado em nossa base de dados.');
        }
    }
    //################################################################################################
    // FUNÇÃO QUE EXIBE RETORNANDO OS DADOS DA EMPRESA PARA VIEW
    public function show(string $cnpj): View
    {
        $cnpjApenasNumeros = preg_replace('/[^0-9]/', '', $cnpj); // Mantém limpeza

        if (session()->has('found_estabelecimento') && session()->has('found_empresa')) {
            $estabelecimento = session('found_estabelecimento');
            $empresa = session('found_empresa');
            $empresa->load('socios.qualificacao'); 
            $estabelecimento->loadMissing('municipioRel'); 
        } 

        else {
            // Busca o estabelecimento específico
            $estabelecimento = Estabelecimento::where('cnpj_basico', substr($cnpjApenasNumeros, 0, 8))
                                    ->where('cnpj_ordem', substr($cnpjApenasNumeros, 8, 4))
                                    ->where('cnpj_dv', substr($cnpjApenasNumeros, 12, 2))
                                    ->with('municipioRel') 
                                    ->first(); 
            // Busca a empresa e carrega as relações
            $empresa = Empresa::with('socios.qualificacao', 'naturezaJuridica')->find(substr($cnpjApenasNumeros, 0, 8));
        }


        
        $situacao = $this->traduzirSituacaoCadastral($estabelecimento->situacao_cadastral);             // SITUAÇÃO CADASTRAL
        $cnaePrincipal = Cnae::find($estabelecimento->cnae_fiscal_principal);                           // CNAE PRINCIPAL
        $cnaesSecundarios = [];                                                                         // CNAEs SECUNDÁRIOS
        if (!empty($estabelecimento->cnae_fiscal_secundaria)) {
            $codigosSecundarios = explode(',', $estabelecimento->cnae_fiscal_secundaria);
            $cnaeObjects = Cnae::whereIn('codigo', $codigosSecundarios)->get();
            $cnaesSecundarios = $cnaeObjects->map(function ($cnae) {
                return [
                    'codigo' => $this->formatarCnae($cnae->codigo),
                    'descricao' => $cnae->descricao
                ];
            })->toArray();
        }
        $logradouroCompleto = trim(implode(' ', [$estabelecimento->tipo_logradouro,$estabelecimento->logradouro . ',',$estabelecimento->numero])); // ENDEREÇO FORMATADO
        $nomeMunicipio = $estabelecimento->municipioRel->descricao;                      // NOME MUNICIPIO (MAISCULO)
        $cidadeUf = trim($nomeMunicipio . ' / ' . $estabelecimento->uf);                 // CIDADE / UF
        
        $enderecoCompletoQuery = urlencode(implode(', ', [                               // ENDEREÇO COMPLETO (BAIRO + CIDADE + UF)
            $logradouroCompleto,
            $estabelecimento->bairro,
            $cidadeUf
        ]));
        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$enderecoCompletoQuery}"; // GOOGLE MAPS URL


        // --- LÓGICA PARA BUSCAR CONTATOS ---
        $telefone1 = null;
        if (!empty($estabelecimento->ddd1) && !empty($estabelecimento->telefone1)) {
            $telefone1 = '(' . $estabelecimento->ddd1 . ') ' . $estabelecimento->telefone1;
        }

        $telefone2 = null;
        if (!empty($estabelecimento->ddd2) && !empty($estabelecimento->telefone2)) {
            $telefone2 = '(' . $estabelecimento->ddd2 . ') ' . $estabelecimento->telefone2;
        }

        $email = $estabelecimento->correio_eletronico ?? null;
        // --- FIM DA LÓGICA ---

        // --- LÓGICA PARA PROCESSAR SÓCIOS ---
        $quadroSocietario = [];
        if ($empresa->socios->isNotEmpty()) {
            $quadroSocietario = $empresa->socios->map(function ($socio) {
                return [
                    'nome' => $socio->nome_socio,
                    'qualificacao' => $socio->qualificacao->descricao ?? 'Não informada', // Usa a relação aninhada
                    'data_entrada' => date('d/m/Y', strtotime($socio->data_entrada_sociedade)),
                ];
            })->toArray();
        }
        // --- FIM DA LÓGICA ---


        // --- LÓGICA PARA EMPRESAS SEMELHANTES ---
        $empresasSemelhantes = $this->findSimilarCompanies($estabelecimento);
        // --- FIM DA LÓGICA ---


        // --- PREPARAÇÃO DOS DADOS ESTRUTURADOS (JSON-LD) ---
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $empresa->razao_social,
            'foundingDate' => $estabelecimento->data_inicio_atividade,
            'legalName' => $empresa->razao_social,
            'url' => url()->current(),
            'vatID' => $cnpjApenasNumeros,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $estabelecimento->tipo_logradouro . ' ' . ($estabelecimento->logradouro ?? '') . ', ' . ($estabelecimento->numero ?? 'S/N'),
                'addressLocality' => $estabelecimento->municipioRel->descricao ?? '',
                'addressRegion' => $estabelecimento->uf ?? '',
                'postalCode' => $estabelecimento->cep,
                'addressCountry' => 'BR',
            ],
        ];

        // Adiciona o telefone de forma condicional e segura
        if (!empty($estabelecimento->ddd1) && !empty($estabelecimento->telefone1)) {
            $structuredData['telephone'] = '+55' . $estabelecimento->ddd1 . $estabelecimento->telefone1;
        }

        if (!empty($estabelecimento->correio_eletronico)) {
            $structuredData['email'] = $estabelecimento->correio_eletronico;
        }


        // --- NOVO: PREPARAÇÃO DOS DADOS OPEN GRAPH (OG Tags) ---
        $ogData = [
            'og:title' => $empresa->razao_social . ' - CNPJ ' . $this->formatarCnpj($cnpjApenasNumeros),
            'og:description' => 'Veja detalhes sobre a empresa ' . $empresa->razao_social . ', inscrita no CNPJ ' . $this->formatarCnpj($cnpjApenasNumeros) .', endereço, atividades e situação cadastral.',
            'og:url' => url()->current(),
            'og:type' => 'website',
            'og:site_name' => 'CNPJ Total', // Ou o nome do seu site
            'og:locale' => 'pt_BR',
            'og:image' => asset('images/social.webp'),
            'og:image:type' => 'image/webp',   
        ];
        // --- FIM DA PREPARAÇÃO OG ---

        $metaData = [
            'description' => 'Veja detalhes sobre a empresa ' . $empresa->razao_social . ', inscrita no CNPJ ' . $this->formatarCnpj($cnpjApenasNumeros) .', endereço, atividades e situação cadastral.',
            
            'keywords' => implode(', ', array_filter([
                $cnpjApenasNumeros,
                $this->formatarCnpj($cnpjApenasNumeros),
                $empresa->razao_social,
                $estabelecimento->nome_fantasia,
                'cnpj ' . $this->formatarCnpj($cnpjApenasNumeros),
                'consulta cnpj',
            ]))
        ];

        // Prepara os dados para os cards
        $dadosParaExibir = [
            // Card: Informações do CNPJ (dados existentes)
            'cnpj_completo' => $this->formatarCnpj($cnpjApenasNumeros),
            'razao_social' => $empresa->razao_social,
            'nome_fantasia' => $estabelecimento->nome_fantasia,
            'natureza_juridica' => $empresa->naturezaJuridica->descricao ?? 'Não informado',
            'capital_social' => number_format($empresa->capital_social, 2, ',', '.'),
            'porte' => $this->traduzirPorte($empresa->porte_empresa),
            'matriz_ou_filial' => $estabelecimento->identificador_matriz_filial == 1 ? 'Matriz' : 'Filial',
            'data_abertura' => date('d/m/Y', strtotime($estabelecimento->data_inicio_atividade)),

            // Card: Situação Cadastral (NOVOS DADOS)
            'situacao_cadastral' => $situacao['texto'],
            'situacao_cadastral_classe' => $situacao['classe'],
            'data_situacao_cadastral' => date('d/m/Y', strtotime($estabelecimento->data_situacao_cadastral)),

            // Card: Atividades Econômicas (DADOS ATUALIZADOS)
            'cnae_principal' => [
                'codigo' => $cnaePrincipal ? $this->formatarCnae($cnaePrincipal->codigo) : 'Não informado',
                'descricao' => $cnaePrincipal->descricao ?? 'Não informado'
            ],
            'cnaes_secundarios' => $cnaesSecundarios,

            // Card: Endereço (NOVOS DADOS)
            'logradouro' => $logradouroCompleto,
            'complemento' => $estabelecimento->complemento,
            'bairro' => $estabelecimento->bairro,
            'cidade_uf' => $cidadeUf,
            'cidade' => $nomeMunicipio,
            'cep' => $this->formatarCep($estabelecimento->cep),
            'google_maps_url' => $googleMapsUrl,

            // Card: Contato (NOVOS DADOS)
            'telefone_1' => $telefone1,
            'telefone_2' => $telefone2,
            'email' => $email,

            // Card: Quadro Societário (NOVOS DADOS)
            'quadro_societario' => $quadroSocietario,

            'empresas_semelhantes' => $empresasSemelhantes,

            // DADOS DE CONTEXTO PARA O SUBTÍTULO (NOVO)
            'similar_context' => [
                'cnae_descricao' => $cnaePrincipal->descricao ?? 'Não informado',
                'cidade' => $estabelecimento->municipioRel->descricao ?? 'região'
            ],

            'structured_data' => $structuredData,

            'og_data' => $ogData,

            'meta_data' => $metaData
        ];

        return view('cnpj.show', ['data' => $dadosParaExibir]);
    }
    
    private function findSimilarCompanies(Estabelecimento $estabelecimento): array
    {
        $cnaePrincipal = $estabelecimento->cnae_fiscal_principal;
        $municipio = $estabelecimento->municipio;
        $situacao_cadastral = $estabelecimento->situacao_cadastral;
        $uf = $estabelecimento->uf;
        $cnpjBaseAtual = $estabelecimento->cnpj_basico;
        $limit = 14;


        // ETAPA 1: Busca na mesma CIDADE
        $semelhantesNaCidade = Estabelecimento::where('municipio', $municipio)
            ->where('situacao_cadastral', '=', 2)
            ->where('cnae_fiscal_principal', $cnaePrincipal)
            ->where('cnpj_basico', '!=', $cnpjBaseAtual)
            ->with('empresa:cnpj_basico,razao_social')
            ->limit($limit)
            ->get();
            
        if ($semelhantesNaCidade->count() >= $limit) {
            return $this->formatSimilarCompanies($semelhantesNaCidade);
        }

        // ETAPA 2: Busca no ESTADO para completar
        $necessarios = $limit - $semelhantesNaCidade->count();
        $cnpjsJaEncontrados = $semelhantesNaCidade->pluck('cnpj_basico')->push($cnpjBaseAtual);
        
        $semelhantesNoEstado = Estabelecimento::where('uf', $uf)
            ->where('situacao_cadastral', '=', 2)
            ->where('cnae_fiscal_principal', $cnaePrincipal)
            ->whereNotIn('cnpj_basico', $cnpjsJaEncontrados)
            ->with('empresa:cnpj_basico,razao_social')
            ->limit($necessarios)
            ->get();
        
        $empresasSemelhantes = $semelhantesNaCidade->merge($semelhantesNoEstado);

        return $this->formatSimilarCompanies($empresasSemelhantes);
    }


    private function formatSimilarCompanies($collection): array
    {
        return $collection->map(function ($est) {
            $cnpjCompleto = $est->cnpj_basico . $est->cnpj_ordem . $est->cnpj_dv;
            return [
                'razao_social' => $est->empresa->razao_social,
                'cidade_uf' => ($est->municipioRel->descricao ?? '') . ' / ' . $est->uf,
                'url' => route('cnpj.show', ['cnpj' => $cnpjCompleto]),
            ];
        })->toArray();
    }

    // ###########################################################################################################################
    private function formatarCep(string $cep): string
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
        if (strlen($cepLimpo) === 8) {
            return vsprintf('%s%s.%s%s%s-%s%s%s', str_split($cepLimpo));
        }
        return $cep;
    }
    // ###########################################################################################################################
    // FUNÇÃO FORMATAR CNAE
    private function formatarCnae(string $codigo): string
    {
        // 1. Remove qualquer caractere que não seja um dígito
        $codigoLimpo = preg_replace('/\D/', '', $codigo);

        // 2. Se o código tiver 6 dígitos, adiciona um zero à esquerda para normalizar.
        if (strlen($codigoLimpo) === 6) {
            $codigoLimpo = '0' . $codigoLimpo;
        }

        // 3. Verifica se o código agora tem 7 dígitos
        if (strlen($codigoLimpo) === 7) {
            // 4. Aplica a formatação padrão XXXX-X/XX usando substr, que é mais seguro
            return substr($codigoLimpo, 0, 4) . '-' . substr($codigoLimpo, 4, 1) . '/' . substr($codigoLimpo, 5, 2);
        }

        // 5. Se o código não se encaixar no padrão, retorna o original para evitar quebrar a aplicação.
        return $codigo;
    }
    // ###########################################################################################################################
    // FUNÇÃO TRADUZIR PORTE DA EMPRESA
    private function traduzirPorte(int $codigoPorte): string
    {
        switch ($codigoPorte) {
            case 1:
                return 'Micro Empresa';
            case 3:
                return 'Empresa de Pequeno Porte';
            case 5:
                return 'Demais';
            default:
                return 'Não Informado';
        }
    }
    // ###########################################################################################################################
    // FUNÇÃO TRADUZIR SITUAÇÃO CADASTRAL
    private function traduzirSituacaoCadastral(int $codigo): array
    {
        switch ($codigo) {
            case 2:
                return ['texto' => 'ATIVA', 'classe' => 'status-active'];
            case 3:
                return ['texto' => 'SUSPENSA', 'classe' => 'status-suspended'];
            case 4:
                return ['texto' => 'BAIXADA', 'classe' => 'status-inactive'];
            case 8:
                return ['texto' => 'NULA', 'classe' => 'status-inactive'];
            default:
                return ['texto' => 'NÃO INFORMADO', 'classe' => 'status-inactive'];
        }
    }
    // ###########################################################################################################################
    // FUNÇÃO FORMATAR CNPJ
    private function formatarCnpj(string $cnpj): string
    {
        return vsprintf('%s.%s.%s/%s-%s', [
            substr($cnpj, 0, 2), substr($cnpj, 2, 3), substr($cnpj, 5, 3),
            substr($cnpj, 8, 4), substr($cnpj, 12, 2)
        ]);
    }
    // ###########################################################################################################################

}