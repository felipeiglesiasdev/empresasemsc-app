@extends('layouts.app')

@push('seo_tags')
    <title>Empresas em {{ $municipio->descricao }} - SC | Lista Atualizada</title>
    <meta name="description" content="Lista de empresas ativas em {{ $municipio->descricao }}, Santa Catarina. Consulte CNPJ, endereço e capital social de {{ number_format($totalEmpresas, 0, ',', '.') }} negócios locais.">
    <link rel="canonical" href="{{ route('municipios.show', ['slug' => Str::slug($municipio->descricao)]) }}" />
@endpush

@section('content')

    {{-- Hero do Município --}}
    <x-municipios.show.hero 
        :municipio="$municipio" 
        :totalEmpresas="$totalEmpresas" 
    />

    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            
            {{-- Lista de Empresas (Tabela + Paginação) --}}
            <x-municipios.show.listing 
                :empresas="$empresas" 
            />

            {{-- FAQ do Município --}}
            <x-municipios.show.faq 
                :municipio="$municipio" 
                :totalEmpresas="$totalEmpresas"
            />
            
        </div>
    </section>

@endsection