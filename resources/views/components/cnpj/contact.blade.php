@props(['data'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center gap-3">
        <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
            <i class="bi bi-geo-alt-fill text-lg"></i>
        </div>
        <h2 class="font-bold text-gray-800 text-lg">Localização e Contato</h2>
    </div>
    
    <div class="p-6 space-y-6">
        
        {{-- Endereço --}}
        <div>
            <p class="text-gray-800 font-medium text-lg mb-1">
                {{ $data['logradouro'] }}
                @if($data['complemento']) <br><span class="text-sm text-gray-500">{{ $data['complemento'] }}</span> @endif
            </p>
            <p class="text-gray-600 mb-3">
                {{ $data['bairro'] }} <br>
                {{ $data['cidade_uf'] }} <br>
                CEP: {{ $data['cep'] }}
            </p>
            
            <a href="{{ $data['google_maps_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full px-4 py-2 bg-white border border-indigo-200 text-indigo-600 font-bold rounded-lg hover:bg-indigo-50 transition-colors text-sm shadow-sm">
                <i class="bi bi-map mr-2"></i> Ver no Google Maps
            </a>
        </div>

        <hr class="border-gray-100">

        {{-- Contatos --}}
        <div class="space-y-3">
            @if($data['telefone_1'])
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <i class="bi bi-telephone-fill text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Telefone</p>
                        <p class="text-gray-800 font-medium">{{ $data['telefone_1'] }}</p>
                    </div>
                </div>
            @endif

            @if($data['telefone_2'])
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <i class="bi bi-telephone-fill text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Telefone 2</p>
                        <p class="text-gray-800 font-medium">{{ $data['telefone_2'] }}</p>
                    </div>
                </div>
            @endif

            @if($data['email'])
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="bi bi-envelope-fill text-sm"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs text-gray-400 uppercase font-bold">E-mail</p>
                        <p class="text-gray-800 font-medium truncate" title="{{ $data['email'] }}">{{ strtolower($data['email']) }}</p>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>