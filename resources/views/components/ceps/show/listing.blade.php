@props(['empresas'])

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-12">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold text-indigo-900">CNPJ / Abertura</th>
                    <th scope="col" class="px-6 py-4 font-bold text-indigo-900">Empresa</th>
                    <th scope="col" class="px-6 py-4 font-bold text-indigo-900 text-right">Capital social</th>
                    <th scope="col" class="px-6 py-4 text-right font-bold text-indigo-900">Ação</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($empresas as $estabelecimento)
                    @php
                        $cnpjCompleto = $estabelecimento->cnpj_basico . $estabelecimento->cnpj_ordem . $estabelecimento->cnpj_dv;
                        $cnpjFormatado = vsprintf('%s.%s.%s/%s-%s', [
                            substr($cnpjCompleto, 0, 2), substr($cnpjCompleto, 2, 3), substr($cnpjCompleto, 5, 3),
                            substr($cnpjCompleto, 8, 4), substr($cnpjCompleto, 12, 2)
                        ]);
                    @endphp
                    <tr class="hover:bg-indigo-50/40 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900 font-mono font-medium text-sm">{{ $cnpjFormatado }}</div>
                            <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="bi bi-calendar4-week"></i>
                                {{ date('d/m/Y', strtotime($estabelecimento->data_inicio_atividade)) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900 font-bold truncate max-w-xs text-base group-hover:text-indigo-700 transition-colors" title="{{ $estabelecimento->empresa->razao_social }}">
                                {{ $estabelecimento->empresa->razao_social }}
                            </div>
                            @if($estabelecimento->nome_fantasia)
                                <div class="text-xs text-gray-500 uppercase truncate max-w-xs mt-1 font-medium tracking-wide">
                                    {{ $estabelecimento->nome_fantasia }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="text-gray-900 font-mono font-medium">
                                R$ {{ number_format($estabelecimento->empresa->capital_social, 2, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('cnpj.show', ['cnpj' => $cnpjCompleto]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 border border-indigo-100 text-xs font-bold rounded-lg text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white transition-all shadow-sm hover:shadow-md">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="bi bi-inbox text-3xl text-gray-300"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Nenhuma empresa encontrada</h3>
                                <p class="text-sm mt-1">Não encontramos registros ativos para este CEP no momento.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($empresas->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $empresas->links() }}
        </div>
    @endif
</div>
