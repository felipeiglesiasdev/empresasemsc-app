@props(['data'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden top-6">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center gap-3 justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                <i class="bi bi-geo-alt-fill text-lg"></i>
            </div>
            <h2 class="font-bold text-gray-800 text-lg">Localização e Contato</h2>
        </div>
        <span class="text-xs font-semibold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full">LGPD</span>
    </div>

    <div class="p-6 space-y-6">
        {{-- Endereço resumido --}}
        <div>
            <!-- Exibimos apenas bairro e cidade/UF para proteger informações sensíveis -->
            <p class="text-gray-800 font-medium text-lg mb-1">{{ $data['bairro'] }}</p>
            <p class="text-gray-600 mb-3">{{ $data['cidade_uf'] }}</p>
        </div>

        <hr class="border-gray-100">

        {{-- Contatos (ocultos) --}}
        <div class="space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="bi bi-telephone-fill text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Telefone</p>
                    <p class="text-gray-800 font-medium">***</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="bi bi-envelope-fill text-sm"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs text-gray-400 uppercase font-bold">E-mail</p>
                    <p class="text-gray-800 font-medium truncate">***</p>
                </div>
            </div>

            <p class="text-xs text-gray-500 leading-relaxed">
                Os dados de contato foram ocultados com *** porque não podem ser exibidos publicamente conforme a Lei Geral de Proteção de Dados (LGPD).
            </p>
        </div>
    </div>
</div>
