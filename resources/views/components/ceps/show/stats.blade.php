@props(['cepFormatado', 'dadosCep', 'totalEmpresas', 'topCnaes'])

{{-- Cartão principal de estatísticas --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between">
        <div>
            <div class="text-xs uppercase text-gray-500 tracking-widest">Empresas ativas</div>
            <div class="text-3xl font-black text-indigo-900 mt-1">{{ number_format($totalEmpresas, 0, ',', '.') }}</div>
            <p class="text-sm text-gray-500 mt-2">Quantidade de estabelecimentos vinculados ao CEP {{ $cepFormatado }}.</p>
        </div>
    </div>
    {{-- Espaço reservado para futuras estatísticas. --}}
    <div class="hidden sm:block"></div>
</div>

{{-- Seção de CNAEs --}}
<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm mb-12">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Principais CNAEs do CEP</h3>
        <span class="text-xs text-gray-500">Top {{ $topCnaes->count() }} atividades econômicas</span>
    </div>

    @if($topCnaes->isEmpty())
        <p class="text-sm text-gray-500">Ainda não há distribuição de CNAEs para este CEP.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($topCnaes as $cnae)
                <div class="group border border-indigo-100 rounded-lg p-4 bg-indigo-50/20 hover:bg-indigo-50 transition-colors">
                    <span class="inline-block text-[10px] font-bold text-indigo-700 uppercase bg-indigo-100 rounded-full px-2 py-1 mb-2">
                        CNAE {{ $cnae->cnae_fiscal_principal }}
                    </span>
                    <div class="text-sm font-semibold text-gray-900 leading-snug line-clamp-3">
                        {{ $cnae->descricao }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">{{ number_format($cnae->total, 0, ',', '.') }} empresas</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
