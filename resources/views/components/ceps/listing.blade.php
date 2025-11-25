@props(['ceps'])

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900">CEPs com empresas ativas</h2>
            <p class="text-sm text-gray-500">Ordenados pelos CEPs com maior quantidade de estabelecimentos.</p>
        </div>
        <div class="text-sm text-gray-500">Mostrando {{ $ceps->firstItem() }}–{{ $ceps->lastItem() }} de {{ number_format($ceps->total(), 0, ',', '.') }} CEPs</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6">
        @foreach($ceps as $cep)
            <a href="{{ route('ceps.show', ['cep' => $cep->cep]) }}" class="group block bg-gray-50 border border-gray-200 rounded-lg p-4 hover:border-indigo-500 hover:bg-indigo-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-black text-gray-900 font-mono group-hover:text-indigo-700">
                            {{ substr($cep->cep, 0, 5) }}-{{ substr($cep->cep, 5, 3) }}
                        </div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide mt-1">
                            {{ $cep->municipioRel->descricao ?? 'Santa Catarina' }}
                        </div>
                    </div>
                    <div class="text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-full">
                        {{ number_format($cep->total_empresas, 0, ',', '.') }} empresas
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">SEO local: página otimizada para o CEP como palavra-chave.</p>
            </a>
        @endforeach
    </div>

    @if($ceps->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $ceps->links() }}
        </div>
    @endif
</div>
