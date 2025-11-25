@extends('layouts.app')

@push('seo_tags')
    <title>Lista de CEPs de Santa Catarina | Empresas por CEP</title>
    <meta name="description" content="Explore os CEPs de Santa Catarina com empresas ativas. Descubra quantas empresas existem por CEP e acesse os detalhes de cada região." />
    <link rel="canonical" href="{{ route('ceps.index') }}" />
@endpush

@section('content')
    {{-- Hero e métricas gerais --}}
    <x-ceps.hero
        :totalCeps="$totalCeps"
        :totalEmpresasEstado="$totalEmpresasEstado"
    />

    {{-- Listagem paginada de CEPs --}}
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <x-ceps.listing :ceps="$ceps" />
        </div>
    </section>
@endsection