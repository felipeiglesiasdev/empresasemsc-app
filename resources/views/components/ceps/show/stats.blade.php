@props(['cepFormatado', 'dadosCep', 'totalEmpresas', 'capitalSocialTotal', 'topCnaes'])

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="text-xs uppercase text-gray-500 tracking-widest">Empresas ativas</div>
        <div class="text-3xl font-black text-indigo-900 mt-1">{{ number_format($totalEmpresas, 0, ',', '.') }}</div>
        <p class="text-sm text-gray-500 mt-2">Quantidade de estabelecimentos vinculados ao CEP {{ $cepFormatado }}.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="text-xs uppercase text-gray-500 tracking-widest">Capital social somado</div>
        <div class="text-3xl font-black text-indigo-900 mt-1">R$ {{ number_format($capitalSocialTotal, 2, ',', '.') }}</div>
        <p class="text-sm text-gray-500 mt-2">Soma do capital social das empresas ativas neste CEP.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="text-xs uppercase text-gray-500 tracking-widest">Endereço base</div>
        <div class="text-lg font-bold text-gray-900 mt-1">
            {{ $dadosCep->tipo_logradouro }} {{ $dadosCep->logradouro }}, {{ $dadosCep->bairro }}
        </div>
        <div class="text-sm text-gray-500 mt-1">
            {{ $dadosCep->municipioRel->descricao ?? 'SC' }} - {{ $dadosCep->uf }}
        </div>
        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($dadosCep->tipo_logradouro . ' ' . $dadosCep->logradouro . ', ' . $dadosCep->bairro . ', ' . $dadosCep->municipioRel->descricao . ' - ' . $dadosCep->uf) }}" target="_blank" rel="noopener" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 mt-2 inline-flex items-center gap-1">
            Ver no mapa <i class="bi bi-arrow-up-right"></i>
        </a>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm mb-12">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-bold text-gray-900">Principais CNAEs do CEP</h3>
        <span class="text-xs text-gray-500">Top 5 atividades econômicas</span>
    </div>

    @if($topCnaes->isEmpty())
        <p class="text-sm text-gray-500">Ainda não há distribuição de CNAEs para este CEP.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($topCnaes as $cnae)
                <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                    <div class="text-xs uppercase text-gray-500">CNAE {{ $cnae->cnae_fiscal_principal }}</div>
                    <div class="text-lg font-bold text-gray-900">{{ number_format($cnae->total, 0, ',', '.') }} empresas</div>
                    <p class="text-xs text-gray-500 mt-1">Atividade recorrente entre as empresas deste CEP.</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
