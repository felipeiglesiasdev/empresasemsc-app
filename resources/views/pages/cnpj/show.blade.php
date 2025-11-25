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

    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Coluna Principal (Esquerda) --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Dados Básicos --}}
                    <x-cnpj.basic-info :data="$data" />

                    {{-- Atividades (CNAEs) --}}
                    <x-cnpj.activities :data="$data" />

                    {{-- Sócios --}}
                    <x-cnpj.partners :data="$data" />

                </div>

                {{-- Coluna Lateral (Direita) --}}
                <div class="space-y-8">
                    
                    {{-- Card de Contato e Endereço --}}
                    <x-cnpj.contact :data="$data" />

                    {{-- Anúncio ou Call to Action (Espaço reservado) --}}
                    <div class="bg-indigo-900 rounded-xl p-6 text-center text-white shadow-lg">
                        <i class="bi bi-shield-check text-4xl mb-3 block"></i>
                        <h3 class="font-bold text-lg mb-2">Dados Públicos</h3>
                        <p class="text-indigo-200 text-sm">Estas informações são públicas e fornecidas pela Receita Federal do Brasil.</p>
                    </div>

                </div>

            </div>

            {{-- Seção Inferior: Empresas Semelhantes --}}
            @if(!empty($data['empresas_semelhantes']))
                <x-cnpj.similar :similar="$data['empresas_semelhantes']" :context="$data['similar_context']" />
            @endif

            {{-- Botão Voltar --}}
            <div class="mt-12 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 font-bold hover:underline">
                    <i class="bi bi-arrow-left mr-2"></i> Realizar nova consulta
                </a>
            </div>

        </div>
    </section>

@endsection