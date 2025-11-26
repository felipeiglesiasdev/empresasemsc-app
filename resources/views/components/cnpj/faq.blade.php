@props(['data'])

<div id="faq" class="max-w-3xl mx-auto mt-16" x-data="{ active: null }">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-gray-900">Dúvidas frequentes sobre este CNPJ</h2>
        <p class="text-gray-500 mt-1">Informações rápidas para entender o cadastro da empresa e otimizar o SEO da página.</p>
    </div>

    <div class="space-y-4">
        {{-- 1. Razão social do CNPJ --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 1 ? null : 1)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Qual a razão social do CNPJ {{ $data['cnpj_completo'] }}?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 1 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 1" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                A razão social da empresa inscrita no CNPJ {{ $data['cnpj_completo'] }} é <strong>{{ $data['razao_social'] }}</strong>.
            </div>
        </div>

        {{-- 2. Natureza jurídica --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 2 ? null : 2)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Qual a natureza jurídica da empresa {{ $data['razao_social'] }}?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 2 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 2" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                A natureza jurídica desta empresa é <strong>{{ $data['natureza_juridica'] }}</strong>, conforme registrado na Receita Federal.
            </div>
        </div>

        {{-- 3. Atividade econômica principal --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 3 ? null : 3)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Qual é a principal atividade econômica?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 3 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 3" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                O CNAE principal desta empresa é <strong>{{ $data['cnae_principal']['codigo'] }} - {{ $data['cnae_principal']['descricao'] }}</strong>.
            </div>
        </div>

        {{-- 4. Porte e capital social --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 4 ? null : 4)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Qual o porte e capital social da empresa?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 4 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 4" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                A empresa é classificada como <strong>{{ $data['porte'] }}</strong> e possui capital social declarado de <strong>R$ {{ $data['capital_social'] }}</strong>.
            </div>
        </div>

        {{-- 5. Situação cadastral --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 5 ? null : 5)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Qual a situação cadastral?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 5 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 5" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                A situação cadastral atual da empresa é <strong>{{ $data['situacao_cadastral'] }}</strong> desde {{ $data['data_situacao_cadastral'] }}.
            </div>
        </div>

        {{-- 6. Localização disponibilizada --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 6 ? null : 6)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Onde a empresa está localizada?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 6 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 6" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Para proteger a privacidade dos responsáveis, exibimos apenas informações de bairro e cidade/UF: <strong>{{ $data['bairro'] }}</strong> — {{ $data['cidade_uf'] }}.
            </div>
        </div>

        {{-- 7. Dados de contato e LGPD --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-sm">
            <button @click="active = (active === 7 ? null : 7)" class="flex items-center justify-between w-full p-5 text-left bg-white focus:outline-none">
                <span class="font-bold text-gray-900">Por que dados de contato não aparecem?</span>
                <span class="ml-6 flex-shrink-0 text-indigo-500 transform transition-transform duration-300" :class="{ 'rotate-180': active === 7 }">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </button>
            <div x-show="active === 7" x-collapse style="display: none;" class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                Informações como e‑mail, telefones e identificação de sócios são ocultadas com *** em respeito à Lei Geral de Proteção de Dados (LGPD). Divulgamos apenas informações públicas permitidas pela legislação.
            </div>
        </div>
    </div>
</div>
