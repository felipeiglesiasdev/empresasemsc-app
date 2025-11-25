@extends('layouts.app')
@push('seo_tags')
    @include('components.home.tags')
@endpush
@section('content')
    <x-home.hero />
    <x-home.stats 
        :totalAtivasSC="$totalAtivasSC"
        :balancoSC="$balancoSC"
        :anoAtual="$anoAtual"
        :statsSituacaoSC="$statsSituacaoSC"
    />
    <x-home.municipios :municipios="$top10CidadesSC" />
    <x-home.ceps :ceps="$randomCepsSC" />
    <x-home.faq />
    
@endsection
