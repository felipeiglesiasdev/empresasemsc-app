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

                {{-- Tags removidas para esta página --}}

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Coluna Principal (Esquerda) --}}
                    <div class="lg:col-span-2 space-y-8">
                       <x-cnpj.basic-info :data="$data" />
                        <x-cnpj.activities :data="$data" />
                        <x-cnpj.removal :data="$data" />
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
            {{-- Substituímos a FAQ estática por um componente interativo que segue o padrão das outras páginas e inclui palavras-chave para SEO. --}}
            <x-cnpj.faq :data="$data" />

            {{-- Botão Voltar --}}
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 font-bold hover:underline">
                    <i class="bi bi-arrow-left mr-2"></i> Realizar nova consulta
                </a>
            </div>

        </div>
    </section>

@endsection
