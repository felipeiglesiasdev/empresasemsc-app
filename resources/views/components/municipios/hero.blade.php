@props(['totalMunicipios', 'totalEmpresasEstado'])

<section class="bg-indigo-900 py-16 relative overflow-hidden">
    {{-- Pattern de fundo sutil --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white mb-4 tracking-tight">
            Municípios de Santa Catarina
        </h1>
        <p class="text-indigo-200 text-lg sm:text-xl max-w-2xl mx-auto">
            Monitoramos <span class="font-bold text-white border-b-2 border-indigo-500">{{ number_format($totalEmpresasEstado, 0, ',', '.') }}</span> empresas ativas espalhadas por <span class="font-bold text-white border-b-2 border-indigo-500">{{ $totalMunicipios }}</span> cidades.
        </p>
    </div>
</section>