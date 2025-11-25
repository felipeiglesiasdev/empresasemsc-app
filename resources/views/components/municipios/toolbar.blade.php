<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-10">
    
    {{-- Campo de Busca em Tempo Real --}}
    <div class="relative max-w-2xl mx-auto mb-8">
        <input 
            type="text" 
            x-model="search"
            placeholder="Busque sua cidade (ex: Florianópolis, Chapecó...)" 
            class="w-full pl-14 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-800 placeholder-gray-400 transition-all text-lg shadow-inner"
        >
        <div class="absolute left-5 top-1/2 transform -translate-y-1/2 text-indigo-400">
            <i class="bi bi-search text-xl"></i>
        </div>
        
        {{-- Botão limpar busca (aparece só quando digita) --}}
        <button 
            x-show="search.length > 0 || letter.length > 0" 
            @click="search = ''; letter = ''"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xs text-indigo-600 hover:text-indigo-800 font-bold bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors cursor-pointer"
            style="display: none;"
            x-transition>
            LIMPAR
        </button>
    </div>

    {{-- Filtro Alfabético --}}
    <div class="flex flex-wrap justify-center gap-1.5 sm:gap-2">
        {{-- Botão Todas --}}
        <button 
            @click="letter = ''"
            :class="letter === '' ? 'bg-indigo-600 text-white shadow-md scale-105' : 'bg-gray-50 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600'"
            class="px-3 py-1.5 rounded-lg text-sm font-bold transition-all duration-200 border border-transparent">
            TODAS
        </button>

        @foreach(range('A', 'Z') as $char)
            <button 
                @click="letter = '{{ $char }}'; search = ''" 
                :class="letter === '{{ $char }}' ? 'bg-indigo-600 text-white shadow-md scale-110' : 'bg-gray-50 text-gray-500 hover:bg-indigo-100 hover:text-indigo-700'"
                class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg text-sm font-bold transition-all duration-200 border border-transparent">
                {{ $char }}
            </button>
        @endforeach
    </div>
</div>