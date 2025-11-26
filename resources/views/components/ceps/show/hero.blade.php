@props(['cepFormatado', 'dadosCep', 'totalEmpresas'])

<section class="bg-indigo-900 py-10 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex mb-4 text-xs font-medium text-indigo-300" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Início</a>
                </li>
                <li><span class="mx-1">/</span></li>
                <li>
                    <a href="{{ route('ceps.index') }}" class="hover:text-white transition-colors">CEPs</a>
                </li>
                <li><span class="mx-1">/</span></li>
                <li aria-current="page">
                    <span class="text-white font-bold">{{ $cepFormatado }}</span>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-800 text-indigo-200 text-xs font-bold uppercase tracking-wider mb-3 border border-indigo-700">
                    CEP em Santa Catarina
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Empresas no CEP {{ $cepFormatado }}
                </h1>
                <p class="text-indigo-200 text-sm sm:text-base mt-2 max-w-2xl">
                    CEP localizado em {{ $dadosCep->municipioRel->descricao ?? 'Santa Catarina' }} com {{ number_format($totalEmpresas, 0, ',', '.') }} empresas ativas cadastradas.
                </p>
            </div>

            <div class="hidden lg:block">
                <a href="#faq" class="text-indigo-300 hover:text-white text-sm font-medium transition-colors flex items-center gap-1">
                    <i class="bi bi-question-circle"></i> Dúvidas sobre este CEP?
                </a>
            </div>
        </div>
    </div>
</section>
