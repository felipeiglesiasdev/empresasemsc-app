@props(['cepFormatado', 'totalEmpresas'])

<div id="faq" class="max-w-3xl mx-auto mt-16" x-data="{ active: null }">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-gray-900">Dúvidas frequentes sobre o CEP {{ $cepFormatado }}</h2>
        <p class="text-gray-500 mt-1">SEO local para empresas que usam o CEP como referência.</p>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 1 ? null : 1)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Quantas empresas existem neste CEP?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 1 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 1" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Atualmente, há <strong>{{ number_format($totalEmpresas, 0, ',', '.') }}</strong> empresas ativas cadastradas com este CEP em Santa Catarina.
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 2 ? null : 2)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Posso usar o CEP como palavra-chave?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 2 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 2" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Sim. Esta página foi pensada para SEO local, destacando o CEP {{ $cepFormatado }} no título, descrição e conteúdo para reforçar a relevância da palavra-chave nos buscadores.
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 3 ? null : 3)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Como consultar uma empresa específica?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 3 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 3" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Use a lista acima para abrir os detalhes do CNPJ desejado ou utilize o formulário de busca por CNPJ disponível na página inicial.
            </div>
        </div>
    </div>
</div>
