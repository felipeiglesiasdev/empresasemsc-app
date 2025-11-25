<section class="py-16 sm:py-24 bg-white" itemscope itemtype="https://schema.org/FAQPage">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                Perguntas Frequentes
            </h2>
            <p class="text-lg text-gray-600">
                Tire suas dúvidas sobre a consulta de dados empresariais em Santa Catarina.
            </p>
        </div>

        <div class="space-y-6" x-data="{ active: null }">

            {{-- Pergunta 1 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 cursor-pointer transition-all duration-300 hover:border-indigo-300"
                 @click="active = (active === 1 ? null : 1)"
                 itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" itemprop="name">
                        A consulta de empresas em Santa Catarina é gratuita?
                    </h3>
                    <span class="text-indigo-600 transform transition-transform duration-300" :class="{ 'rotate-180': active === 1 }">
                        <i class="bi bi-chevron-down text-xl"></i>
                    </span>
                </div>
                <div x-show="active === 1" x-collapse style="display: none;" class="mt-4 text-gray-600 leading-relaxed" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        Sim, a consulta é totalmente gratuita e ilimitada. Você pode pesquisar quantas empresas desejar sem nenhum custo ou restrição de quantidade.
                    </div>
                </div>
            </div>

            {{-- Pergunta 2 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 cursor-pointer transition-all duration-300 hover:border-indigo-300"
                 @click="active = (active === 2 ? null : 2)"
                 itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" itemprop="name">
                        Posso consultar empresas de outros estados além de SC?
                    </h3>
                    <span class="text-indigo-600 transform transition-transform duration-300" :class="{ 'rotate-180': active === 2 }">
                        <i class="bi bi-chevron-down text-xl"></i>
                    </span>
                </div>
                <div x-show="active === 2" x-collapse style="display: none;" class="mt-4 text-gray-600 leading-relaxed" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        Sim, é possível consultar empresas de outros estados. Contudo, como nosso foco é o mercado catarinense, para CNPJs de fora de Santa Catarina exibiremos <strong>apenas a Razão Social</strong> da empresa, sem detalhamento de outros dados.
                    </div>
                </div>
            </div>

            {{-- Pergunta 3 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 cursor-pointer transition-all duration-300 hover:border-indigo-300"
                 @click="active = (active === 3 ? null : 3)"
                 itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" itemprop="name">
                        Como verificar se uma empresa em SC está ativa ou encerrada?
                    </h3>
                    <span class="text-indigo-600 transform transition-transform duration-300" :class="{ 'rotate-180': active === 3 }">
                        <i class="bi bi-chevron-down text-xl"></i>
                    </span>
                </div>
                <div x-show="active === 3" x-collapse style="display: none;" class="mt-4 text-gray-600 leading-relaxed" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        Para verificar a situação cadastral de um CNPJ em SC, basta digitar o número do documento no campo de busca no topo da página. O resultado mostrará instantaneamente se a empresa está Ativa, Baixada (encerrada), Suspensa ou Inapta, além da data da última atualização dessa situação na Receita Federal.
                    </div>
                </div>
            </div>

             {{-- Pergunta 4 (Antiga 5) --}}
             <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 cursor-pointer transition-all duration-300 hover:border-indigo-300"
                 @click="active = (active === 4 ? null : 4)"
                 itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" itemprop="name">
                        Quais dados de CNPJs em Santa Catarina são exibidos?
                    </h3>
                    <span class="text-indigo-600 transform transition-transform duration-300" :class="{ 'rotate-180': active === 4 }">
                        <i class="bi bi-chevron-down text-xl"></i>
                    </span>
                </div>
                <div x-show="active === 4" x-collapse style="display: none;" class="mt-4 text-gray-600 leading-relaxed" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        Exibimos dados estritamente públicos e que não requerem aprovação prévia segundo a Lei Geral de Proteção de Dados (LGPD). Informações como Razão Social, Nome Fantasia, Capital Social, Data de Abertura e Situação Cadastral estão disponíveis. Dados sensíveis de contato, como <strong>telefone, e-mail e endereço completo, permanecem ocultos</strong> para preservar a privacidade.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>