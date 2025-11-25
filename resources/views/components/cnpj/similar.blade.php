@props(['similar', 'context'])

<div class="mt-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-px flex-1 bg-gray-200"></div>
        <h3 class="text-xl font-bold text-gray-800 text-center">
            Outras empresas de <span class="text-indigo-600">{{ $context['cnae_descricao'] }}</span> em {{ explode('/', $context['cidade'])[0] }}
        </h3>
        <div class="h-px flex-1 bg-gray-200"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($similar as $empresa)
            <a href="{{ $empresa['url'] }}" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:border-indigo-300 hover:shadow-md transition-all duration-200 block group">
                <h4 class="font-bold text-gray-800 text-sm group-hover:text-indigo-600 truncate mb-1" title="{{ $empresa['razao_social'] }}">
                    {{ $empresa['razao_social'] }}
                </h4>
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    <i class="bi bi-geo-alt"></i> {{ $empresa['cidade_uf'] }}
                </p>
            </a>
        @endforeach
    </div>
</div>