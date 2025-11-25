@props(['data'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center gap-3">
        <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
            <i class="bi bi-file-text-fill text-lg"></i>
        </div>
        <h2 class="font-bold text-gray-800 text-lg">Informações de Cadastro</h2>
    </div>
    
    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
        
        <div class="space-y-1">
            <p class="text-xs font-bold text-gray-400 uppercase">Data de Abertura</p>
            <p class="text-gray-900 font-medium flex items-center gap-2">
                <i class="bi bi-calendar-check text-indigo-500"></i>
                {{ $data['data_abertura'] }}
            </p>
        </div>

        <div class="space-y-1">
            <p class="text-xs font-bold text-gray-400 uppercase">Porte da Empresa</p>
            <p class="text-gray-900 font-medium flex items-center gap-2">
                <i class="bi bi-bar-chart text-indigo-500"></i>
                {{ $data['porte'] }}
            </p>
        </div>

        <div class="space-y-1">
            <p class="text-xs font-bold text-gray-400 uppercase">Natureza Jurídica</p>
            <p class="text-gray-900 font-medium flex items-center gap-2">
                <i class="bi bi-briefcase text-indigo-500"></i>
                {{ $data['natureza_juridica'] }}
            </p>
        </div>

        <div class="space-y-1">
            <p class="text-xs font-bold text-gray-400 uppercase">Capital Social</p>
            <p class="text-gray-900 font-medium flex items-center gap-2">
                <i class="bi bi-cash-stack text-green-600"></i>
                R$ {{ $data['capital_social'] }}
            </p>
        </div>

        <div class="sm:col-span-2 pt-4 border-t border-gray-100 mt-2">
            <div class="flex items-start gap-3">
                <div class="mt-1">
                    <i class="bi bi-info-circle text-gray-400"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Status Cadastral</p>
                    <p class="text-gray-900 font-medium">
                        {{ $data['situacao_cadastral'] }} desde {{ $data['data_situacao_cadastral'] }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>