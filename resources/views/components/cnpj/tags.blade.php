@props(['data'])

@php
    $tags = collect([
        $data['cnae_principal']['descricao'] ?? null,
        $data['cidade_uf'] ?? null,
        $data['porte'] ?? null,
        $data['natureza_juridica'] ?? null,
        $data['situacao_cadastral'] ?? null,
    ])->filter()->unique()->values();
@endphp

@if($tags->isNotEmpty())
    <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-4 flex flex-wrap gap-3">
        @foreach($tags as $tag)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold">
                <i class="bi bi-hash"></i> {{ $tag }}
            </span>
        @endforeach
    </div>
@endif
