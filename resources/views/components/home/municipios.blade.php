@props(['municipios'])

<section class="py-16 bg-gradient-to-b from-white to-indigo-50/30">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Principais Polos Empresariais
            </h2>
            <p class="text-gray-500 mt-2 text-lg">
                As 10 cidades que lideram o empreendedorismo em Santa Catarina.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach($municipios as $cidade)
                {{-- ROTA CORRIGIDA: Usa o slug da cidade --}}
                <a href="{{ route('municipios.show', ['slug' => Str::slug($cidade->descricao)]) }}" class="group block bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-indigo-50 hover:border-indigo-200 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xl font-bold text-indigo-200 group-hover:text-indigo-600 transition-colors">
                            #{{ $loop->iteration }}
                        </span>
                        <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="bi bi-geo-alt-fill text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-700 truncate mb-1" title="{{ $cidade->descricao }}">
                        {{ $cidade->descricao }}
                    </h3>
                    <p class="text-sm text-gray-500 font-medium">
                        {{ number_format($cidade->total, 0, ',', '.') }} empresas ativas
                    </p>
                </a>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            {{-- ROTA CORRIGIDA: Ver todos os municípios --}}
            <a href="{{ route('municipios.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-indigo-600 bg-indigo-100 hover:bg-indigo-200 transition-colors duration-300 cursor-pointer">
                Ver mapa completo de cidades
                <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>