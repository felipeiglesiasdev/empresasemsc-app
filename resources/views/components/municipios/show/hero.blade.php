@props(['municipio', 'totalEmpresas'])

<section class="bg-indigo-900 py-10 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-4 relative z-10">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-4 text-xs font-medium text-indigo-300" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Início</a>
                </li>
                <li><span class="mx-1">/</span></li>
                <li>
                    <a href="{{ route('municipios.index') }}" class="hover:text-white transition-colors">Municípios</a>
                </li>
                <li><span class="mx-1">/</span></li>
                <li aria-current="page">
                    <span class="text-white font-bold">{{ $municipio->descricao }}</span>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-800 text-indigo-200 text-xs font-bold uppercase tracking-wider mb-3 border border-indigo-700">
                    Município de Santa Catarina
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Empresas em {{ $municipio->descricao }}
                </h1>
                <p class="text-indigo-200 text-sm sm:text-base mt-2 max-w-2xl">
                    Explore o cenário econômico local. Atualmente listando <span class="font-bold text-white border-b border-indigo-500">{{ number_format($totalEmpresas, 0, ',', '.') }}</span> empresas ativas.
                </p>
            </div>
            
            {{-- Botão de ação secundário (opcional) --}}
            <div class="hidden lg:block">
                <a href="#faq" class="text-indigo-300 hover:text-white text-sm font-medium transition-colors flex items-center gap-1">
                    <i class="bi bi-question-circle"></i> Dúvidas sobre a cidade?
                </a>
            </div>
        </div>
    </div>
</section>