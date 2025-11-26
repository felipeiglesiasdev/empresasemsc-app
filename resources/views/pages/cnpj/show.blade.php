@extends('layouts.app')

@push('seo_tags')
    {{-- As tags de SEO vêm do controller via variável $data['meta_data'], etc --}}
    <title>{{ $data['razao_social'] }} - CNPJ {{ $data['cnpj_completo'] }} | Empresas SC</title>
    <meta name="description" content="{{ $data['meta_data']['description'] }}">
    <meta name="keywords" content="{{ $data['meta_data']['keywords'] }}">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $data['og_data']['og:title'] }}">
    <meta property="og:description" content="{{ $data['og_data']['og:description'] }}">
    <meta property="og:url" content="{{ $data['og_data']['og:url'] }}">
    <meta property="og:type" content="website">

    <!-- Structured Data -->
    <script type="application/ld+json">
        {!! json_encode($data['structured_data']) !!}
    </script>
@endpush

@section('content')

    {{-- Hero Section com Título e Status --}}
    <x-cnpj.hero :data="$data" />

    <section class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="container mx-auto px-4 space-y-10">

            <div class="space-y-6">
                {{-- Tags e contexto rápido --}}
                <x-cnpj.tags :data="$data" />

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Coluna Principal (Esquerda) --}}
                    <div class="lg:col-span-2 space-y-8">
                        <x-cnpj.basic-info :data="$data" />
                        <x-cnpj.activities :data="$data" />
                        <x-cnpj.partners :data="$data" />
                    </div>

                    {{-- Coluna Lateral (Direita) --}}
                    <div class="space-y-8">
                        <x-cnpj.contact :data="$data" />

                        <div class="bg-indigo-900 rounded-2xl p-6 text-white shadow-lg space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="bg-white/20 p-2 rounded-lg">
                                    <i class="bi bi-shield-lock text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-1">Respeito à LGPD</h3>
                                    <p class="text-indigo-100 text-sm leading-relaxed">
                                        Dados sensíveis como e-mail, telefone e identificação de sócios estão ocultados (***), pois não podem ser exibidos publicamente conforme a Lei Geral de Proteção de Dados.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- FAQ sobre o CNPJ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                        <i class="bi bi-question-circle text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Perguntas frequentes sobre este CNPJ</h2>
                        <p class="text-sm text-gray-600">Informações gerais para entender o cadastro da empresa.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">1. Qual é a natureza jurídica desta empresa?</p>
                        <p class="text-gray-600">A natureza jurídica informada é "{{ $data['natureza_juridica'] }}", que define o enquadramento legal do negócio.</p>
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">2. Qual é a principal atividade econômica?</p>
                        <p class="text-gray-600">O CNAE principal é {{ $data['cnae_principal']['codigo'] }} - {{ $data['cnae_principal']['descricao'] }}, conforme registro ativo.</p>
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">3. Onde a empresa está localizada?</p>
                        <p class="text-gray-600">O endereço público informado é {{ $data['logradouro'] }}, {{ $data['bairro'] }} - {{ $data['cidade_uf'] }}.</p>
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">4. Qual é o porte e capital social?</p>
                        <p class="text-gray-600">A empresa é classificada como "{{ $data['porte'] }}" e possui capital social declarado de R$ {{ $data['capital_social'] }}.</p>
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">5. Como está a situação cadastral?</p>
                        <p class="text-gray-600">A situação atual é "{{ $data['situacao_cadastral'] }}" desde {{ $data['data_situacao_cadastral'] }}.</p>
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">6. Por que dados de contato não aparecem?</p>
                        <p class="text-gray-600">E-mail, telefones e identificação dos sócios são ocultados com *** e não podem ser exibidos por proteção prevista na LGPD.</p>
                    </div>
                </div>
            </div>

            {{-- Botão Voltar --}}
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 font-bold hover:underline">
                    <i class="bi bi-arrow-left mr-2"></i> Realizar nova consulta
                </a>
            </div>

        </div>
    </section>

@endsection
