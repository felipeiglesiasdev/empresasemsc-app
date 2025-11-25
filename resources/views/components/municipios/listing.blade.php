@props(['municipios'])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($municipios as $municipio)
        {{-- 
            Link atualizado para usar apenas o slug 
            Ex: /municipios/florianopolis
        --}}
        <a href="{{ route('municipios.show', ['slug' => Str::slug($municipio->descricao)]) }}" 
           x-show="match('{{ addslashes($municipio->descricao) }}')"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 transform scale-95"
           x-transition:enter-end="opacity-100 transform scale-100"
           class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-indigo-400 hover:shadow-lg transition-all duration-300 flex flex-col justify-between h-full hover:-translate-y-1">
            
            <div>
                <div class="flex items-center justify-between mb-4">
                    {{-- Círculo com a inicial --}}
                    <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        {{ substr($municipio->descricao, 0, 1) }}
                    </div>

                    {{-- Ranking --}}
                    <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-md group-hover:text-indigo-500 group-hover:bg-indigo-50 transition-colors">
                        #{{ $loop->iteration }}
                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors mb-2 leading-tight">
                    {{ $municipio->descricao }}
                </h3>
            </div>

            {{-- Tag Verde --}}
            <div class="mt-5">
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm font-bold text-center group-hover:bg-green-200 transition-colors flex items-center justify-center gap-2">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>{{ number_format($municipio->total_empresas, 0, ',', '.') }} empresas ativas</span>
                </div>
            </div>
        </a>
    @endforeach
</div>

{{-- Mensagem de "Nenhum resultado" --}}
<div x-show="$el.previousElementSibling.querySelectorAll('a[style*=\'display: none\']').length === {{ count($municipios) }}" 
     style="display: none;"
     class="text-center py-16">
    <div class="bg-indigo-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-400">
        <i class="bi bi-search text-3xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhuma cidade encontrada</h3>
    <p class="text-gray-500">Tente buscar por outro nome ou limpe os filtros.</p>
    <button @click="search = ''; letter = ''" class="mt-4 text-indigo-600 font-bold hover:underline cursor-pointer">
        Limpar filtros
    </button>
</div>