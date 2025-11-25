<header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
    <nav class="container mx-auto px-4 h-20 flex items-center justify-between">
        
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-xl shadow-indigo-200 shadow-lg group-hover:scale-105 transition-transform duration-300">
                <i class="bi bi-buildings-fill"></i>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="text-lg font-black text-gray-900 tracking-tight group-hover:text-indigo-700 transition-colors">
                    EMPRESAS <span class="text-indigo-600">SC</span>
                </span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Dados Públicos</span>
            </div>
        </a>

        {{-- Menu Desktop --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition-colors py-2 border-b-2 border-transparent hover:border-indigo-600">
                Início
            </a>
            <a href="{{ route('municipios.index') }}" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition-colors py-2 border-b-2 border-transparent hover:border-indigo-600">
                Municípios
            </a>
            <a href="" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition-colors py-2 border-b-2 border-transparent hover:border-indigo-600">
                CEPs
            </a>
            
            {{-- Botão CTA --}}
            <a href="{{ route('home') }}#cnpj-input-home" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="bi bi-search mr-2"></i> Consultar CNPJ
            </a>
        </div>

        {{-- Botão Mobile --}}
        <div class="md:hidden flex items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-500 hover:text-indigo-600 focus:outline-none p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                <i class="bi text-3xl" :class="mobileMenuOpen ? 'bi-x' : 'bi-list'"></i>
            </button>
        </div>
    </nav>

    {{-- Menu Mobile (Dropdown) --}}
    <div 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden absolute top-20 left-0 w-full bg-white border-b border-gray-200 shadow-xl py-4 px-4 flex flex-col gap-2"
        style="display: none;"
    >
        <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            Início
        </a>
        <a href="{{ route('municipios.index') }}" class="block px-4 py-3 rounded-lg font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            Municípios
        </a>
        <a href="" class="block px-4 py-3 rounded-lg font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            CEPs
        </a>
        <div class="border-t border-gray-100 my-2 pt-2">
            <a href="{{ route('home') }}" class="block w-full text-center px-4 py-3 rounded-lg font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md">
                Consultar CNPJ
            </a>
        </div>
    </div>
</header>