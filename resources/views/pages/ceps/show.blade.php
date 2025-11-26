@extends('layouts.app')

@push('seo_tags')
    <title>Empresas no CEP {{ $cepFormatado }} - Santa Catarina</title>
    <meta name="description" content="Veja todas as empresas ativas registradas no CEP {{ $cepFormatado }} em {{ $dadosCep->municipioRel->descricao ?? 'Santa Catarina' }}. Página otimizada para SEO local." />
    <link rel="canonical" href="{{ route('ceps.show', ['cep' => $dadosCep->cep]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Empresas no CEP {{ $cepFormatado }}" />
    <meta property="og:description" content="Quantidade de empresas, atividades principais e endereços no CEP {{ $cepFormatado }} em Santa Catarina." />
@endpush

@section('content')
    {{-- Hero do CEP --}}
    <x-ceps.show.hero
        :cepFormatado="$cepFormatado"
        :dadosCep="$dadosCep"
        :totalEmpresas="$totalEmpresas"
    />

    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            {{-- Cards de estatísticas --}}
            <x-ceps.show.stats
                :cepFormatado="$cepFormatado"
                :dadosCep="$dadosCep"
                :totalEmpresas="$totalEmpresas"
                :topCnaes="$topCnaes"
            />

            {{-- Lista de empresas --}}
            <x-ceps.show.listing :empresas="$empresas" />

            {{-- FAQ com respostas rápidas --}}
            <x-ceps.show.faq
                :cepFormatado="$cepFormatado"
                :totalEmpresas="$totalEmpresas"
            />
        </div>
    </section>
@endsection
