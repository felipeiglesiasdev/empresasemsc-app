@props([
    'totalAtivasSC',
    'balancoSC',
    'anoAtual',
    'statsSituacaoSC'
])

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        
        {{-- Cabeçalho da Seção --}}
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                Panorama Empresarial
            </h2>
            <p class="text-gray-500 mt-2">
                Dados em tempo real sobre o ecossistema de Santa Catarina.
            </p>
        </div>

        {{-- Painel Unificado (Substitui os cards múltiplos) --}}
        <div class="bg-indigo-50/80 rounded-3xl p-8 sm:p-10 border border-indigo-100">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-12 items-center">
                
                {{-- Coluna 1: O Grande Número (Destaque) --}}
                <div class="text-center lg:text-left lg:border-r lg:border-indigo-200 lg:pr-8">
                    <div class="inline-flex items-center justify-center p-3 bg-white rounded-2xl shadow-sm text-indigo-600 mb-4">
                        <i class="bi bi-buildings text-3xl"></i>
                    </div>
                    <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wider mb-1">Empresas Ativas</p>
                    <div class="text-5xl sm:text-6xl font-black text-gray-900 tracking-tight">
                        {{ number_format($totalAtivasSC, 0, ',', '.') }}
                    </div>
                    <p class="text-gray-600 mt-3 text-sm leading-relaxed">
                        Total de CNPJs com situação cadastral ativa operando atualmente em Santa Catarina.
                    </p>
                </div>

                {{-- Coluna 2: Balanço do Ano (Lista Clean) --}}
                <div class="lg:border-r lg:border-indigo-200 lg:px-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-calendar4-week text-indigo-500"></i>
                        Movimentação em {{ $anoAtual }}
                    </h3>
                    
                    <div class="space-y-6">
                        {{-- Abertas --}}
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-gray-600 font-medium">Novas Empresas</span>
                                <span class="text-2xl font-bold text-gray-900">{{ number_format($balancoSC['abertas'], 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-indigo-200 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>

                        {{-- Fechadas --}}
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-gray-600 font-medium">Encerradas/Inativas</span>
                                <span class="text-2xl font-bold text-gray-900">{{ number_format($balancoSC['encerradas_inativas'], 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-indigo-200 rounded-full h-1.5">
                                <div class="bg-red-400 h-1.5 rounded-full" style="width: 30%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Coluna 3: Outras Situações (Texto corrido/Lista simples) --}}
                <div class="lg:pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-clipboard-data text-indigo-500"></i>
                        Outras Situações
                    </h3>
                    
                    <ul class="space-y-3">
                        @foreach($statsSituacaoSC as $nome => $total)
                            @if($nome !== 'Ativas') {{-- Não repete 'Ativas' --}}
                            <li class="flex items-center justify-between group">
                                <span class="text-gray-600 group-hover:text-indigo-700 transition-colors">{{ $nome }}</span>
                                <span class="font-semibold text-gray-900 bg-white px-3 py-1 rounded-lg border border-indigo-100 shadow-sm">
                                    {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>