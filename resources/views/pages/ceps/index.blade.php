@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Índice de CEPs Ativos</h1>
        <p class="text-gray-500">Listando códigos postais com atividades empresariais em Santa Catarina.</p>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($ceps as $cep)
            <a href="{{ route('ceps.show', ['cep' => $cep->cep]) }}" class="group block bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all duration-200 text-center">
                <div class="text-lg font-bold text-gray-800 font-mono group-hover:text-indigo-600 transition-colors">
                    {{ substr($cep->cep, 0, 5) }}-{{ substr($cep->cep, 5, 3) }}
                </div>
                <div class="text-xs text-gray-500 mt-1 uppercase tracking-wide">
                    {{ $cep->municipioRel->descricao ?? 'SC' }}
                </div>
            </a>
        @endforeach
    </div>
    
    <div class="mt-10 text-center text-gray-400 text-sm border-t border-gray-100 pt-6">
        Mostrando {{ $ceps->count() }} CEPs encontrados nesta amostragem.
    </div>
</div>
@endsection