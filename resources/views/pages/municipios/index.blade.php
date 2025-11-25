@extends('layouts.app')

@push('seo_tags')
    <title>Municípios de Santa Catarina - Lista de Empresas por Cidade</title>
    <meta name="description" content="Consulte a lista completa de municípios de Santa Catarina. Filtre por cidade para ver o número de empresas ativas.">
@endpush

@section('content')

    {{-- Componente Hero --}}
    <x-municipios.hero 
        :totalMunicipios="$totalMunicipios" 
        :totalEmpresasEstado="$totalEmpresasEstado" 
    />

    {{-- Área Principal com Estado Alpine.js --}}
    <section class="py-12 bg-gray-50 min-h-screen" 
             x-data="{ 
                search: '', 
                letter: '',
                filterData() {
                    // Lógica simples: se tiver letra, filtra por ela. Se tiver busca, filtra por texto.
                    // A busca textual tem prioridade ou atua em conjunto.
                    return true;
                },
                match(nome) {
                    // Normaliza para minúsculas e remove acentos para busca inteligente
                    const cleanNome = nome.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
                    const cleanSearch = this.search.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
                    const startsWithLetter = this.letter === '' || cleanNome.toUpperCase().startsWith(this.letter);
                    const matchesSearch = this.search === '' || cleanNome.includes(cleanSearch);
                    
                    return startsWithLetter && matchesSearch;
                }
             }">
        
        <div class="container mx-auto px-4">
            
            {{-- Componente Toolbar (Busca e Filtros) --}}
            <x-municipios.toolbar />

            {{-- Componente Listagem (Grid) --}}
            <x-municipios.listing :municipios="$municipios" />

        </div>
    </section>

@endsection