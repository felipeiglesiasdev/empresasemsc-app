@props(['data'])

@if(!empty($data['quadro_societario']))
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center gap-3 justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                <i class="bi bi-people-fill text-lg"></i>
            </div>
            <h2 class="font-bold text-gray-800 text-lg">Quadro Societário</h2>
        </div>
        <span class="text-xs font-semibold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full">Dados ocultos (LGPD)</span>
    </div>

    <div class="p-6 space-y-4">
        <p class="text-sm text-gray-600">Os nomes dos sócios foram substituídos por *** para atender às exigências da Lei Geral de Proteção de Dados.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($data['quadro_societario'] as $socio)
                <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition-colors">
                    <div class="mt-1 text-gray-400">
                        <i class="bi bi-person-circle text-2xl"></i>
                    </div>
                    <div class="space-y-1">
                        <p class="font-bold text-gray-900">***</p>
                        <p class="text-sm text-indigo-600 font-medium">{{ $socio['qualificacao'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">Entrada: {{ $socio['data_entrada'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
