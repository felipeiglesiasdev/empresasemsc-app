@props(['data'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center gap-3">
        <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
            <i class="bi bi-gear-wide-connected text-lg"></i>
        </div>
        <h2 class="font-bold text-gray-800 text-lg">Atividades Econômicas</h2>
    </div>
    
    <div class="p-6">
        <div class="mb-6">
            <p class="text-xs font-bold text-indigo-500 uppercase mb-2">Atividade Principal</p>
            <div class="flex items-start gap-3 p-3 bg-indigo-50 rounded-lg border border-indigo-100">
                <span class="font-mono font-bold text-indigo-700 bg-white px-2 py-1 rounded shadow-sm border border-indigo-100">
                    {{ $data['cnae_principal']['codigo'] }}
                </span>
                <span class="text-gray-800 font-medium">{{ $data['cnae_principal']['descricao'] }}</span>
            </div>
        </div>

        @if(!empty($data['cnaes_secundarios']))
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-3">Atividades Secundárias</p>
                <ul class="space-y-2">
                    @foreach($data['cnaes_secundarios'] as $cnae)
                        <li class="flex items-start gap-3 text-sm text-gray-600">
                            <span class="font-mono text-gray-500 min-w-[60px]">{{ $cnae['codigo'] }}</span>
                            <span>{{ $cnae['descricao'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>