@props(['totalCeps', 'totalEmpresasEstado'])

<section class="bg-indigo-900 py-10 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-800 text-indigo-200 text-xs font-bold uppercase tracking-wider mb-3 border border-indigo-700">
                    Banco de CEPs de Santa Catarina
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    CEPs com empresas ativas em SC
                </h1>
                <p class="text-indigo-200 text-sm sm:text-base mt-2 max-w-2xl">
                    Navegue pelos códigos postais catarinenses e descubra quantas empresas estão ativas em cada região.
                </p>

                <div class="mt-4 grid grid-cols-2 gap-3 text-white text-sm">
                    <div class="bg-white/5 border border-white/10 rounded-lg px-4 py-3">
                        <div class="text-xs uppercase tracking-widest text-indigo-200">Total de CEPs</div>
                        <div class="text-2xl font-black">{{ number_format($totalCeps, 0, ',', '.') }}</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-lg px-4 py-3">
                        <div class="text-xs uppercase tracking-widest text-indigo-200">Empresas mapeadas</div>
                        <div class="text-2xl font-black">{{ number_format($totalEmpresasEstado, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-white max-w-sm w-full">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-800 flex items-center justify-center shadow-inner">
                        <i class="bi bi-geo-alt text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-widest text-indigo-200">Cobertura</div>
                        <div class="text-lg font-bold">Todos os municípios de SC</div>
                        <p class="text-xs text-indigo-100 mt-1">Selecione um CEP para ver a lista de empresas e melhorar seu SEO local.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
