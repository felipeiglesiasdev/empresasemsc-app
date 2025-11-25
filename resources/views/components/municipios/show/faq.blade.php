@props(['municipio', 'totalEmpresas'])

<div id="faq" class="max-w-3xl mx-auto mt-16" x-data="{ active: null }">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-gray-900">Dúvidas Frequentes sobre {{ $municipio->descricao }}</h2>
        <p class="text-gray-500 mt-1">Perguntas comuns sobre o cenário empresarial da cidade.</p>
    </div>

    <div class="space-y-4">
        {{-- Pergunta 1 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button 
                @click="active = (active === 1 ? null : 1)"
                class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none"
            >
                <span class="font-bold text-gray-900">Quantas empresas ativas existem em {{ $municipio->descricao }}?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 1 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 1" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Atualmente, registramos <strong>{{ number_format($totalEmpresas, 0, ',', '.') }}</strong> empresas com situação cadastral ativa no município de {{ $municipio->descricao }}, Santa Catarina. Este número é atualizado regularmente conforme os dados da Receita Federal.
            </div>
        </div>

        {{-- Pergunta 2 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button 
                @click="active = (active === 2 ? null : 2)"
                class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none"
            >
                <span class="font-bold text-gray-900">Como consultar dados de uma empresa de {{ $municipio->descricao }}?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 2 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 2" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Você pode consultar os dados de qualquer empresa da cidade utilizando a lista acima ou a busca por CNPJ no topo do nosso site. Disponibilizamos informações públicas como endereço, telefone, capital social e quadro societário de forma gratuita.
            </div>
        </div>

        {{-- Pergunta 3 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button 
                @click="active = (active === 3 ? null : 3)"
                class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none"
            >
                <span class="font-bold text-gray-900">Quais bairros de {{ $municipio->descricao }} têm mais empresas?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 3 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 3" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                A concentração de empresas geralmente ocorre no Centro e em bairros industriais ou comerciais. Ao navegar pela lista de empresas desta página, você pode visualizar o bairro de cada estabelecimento na coluna "Localização" e identificar as áreas com maior atividade econômica em {{ $municipio->descricao }}.
            </div>
        </div>
    </div>
</div>