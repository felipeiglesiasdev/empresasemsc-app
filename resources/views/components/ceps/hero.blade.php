@props(['totalCeps', 'totalEmpresasEstado'])

<section class="bg-indigo-900 py-10 relative z-50">
    <!-- ... trecho do background ... -->
    <div class="container mx-auto px-4 relative z-50">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Coluna 1: título e métricas -->
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-800 text-indigo-200 text-xs font-bold uppercase tracking-wider mb-3 border border-indigo-700">
                    Banco de CEPs de Santa Catarina
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    CEPs com empresas ativas em SC
                </h1>
                <p class="text-indigo-200 text-sm sm:text-base mt-2 max-w-2xl">
                    Navegue pelos códigos postais catarinenses e descubra quantas empresas estão ativas em cada região.
                </p>

                <div class="mt-4 grid grid-cols-2 gap-3 text-white text-sm">
                    <div class="bg-white/5 border border-white/10 rounded-lg px-4 py-3">
                        <div class="text-xs uppercase tracking-widest text-indigo-200">Total de CEPs</div>
                        <div class="text-2xl font-black">{{ number_format($totalCeps, 0, ',', '.') }}</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-lg px-4 py-3">
                        <div class="text-xs uppercase tracking-widest text-indigo-200">Empresas mapeadas</div>
                        <div class="text-2xl font-black">{{ number_format($totalEmpresasEstado, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Coluna 2: busca de CEP com resultados dinâmicos -->
            <!-- Coluna da busca -->
                <div x-data="cepBusca()" class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-white w-full h-full flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-800 flex items-center justify-center shadow-inner">
                            <i class="bi bi-geo-alt text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest text-indigo-200">Buscar CEP</div>
                            <div class="text-lg font-bold">Consulta em tempo real</div>
                            <p class="text-xs text-indigo-100 mt-1">Digite o CEP de Santa Catarina para ver empresas no endereço.</p>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-widest text-indigo-200">CEP</label>
                        <input
                            type="text"
                            x-model="cepDigitado"
                            @input="formatar()"
                            maxlength="9"
                            inputmode="numeric"
                            placeholder="00000-000"
                            class="mt-2 w-full px-3 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-indigo-200 text-white focus:outline-none focus:ring-2 focus:ring-white/60"
                        />
                        <p class="text-[11px] mt-1" :class="valido ? 'text-indigo-100' : 'text-red-200'" x-text="mensagem"></p>
                    </div>
                    <!-- Dropdown de resultados sobreposto -->
                    <div x-show="results.length > 0"
                        class="absolute left-0 right-0 top-full mt-2 bg-white border border-gray-200 shadow-lg rounded-lg overflow-y-auto max-h-60 space-y-1 z-50">
                        <template x-for="item in results" :key="item.cep">
                            <a :href="routeShow(item.cep)"
                            class="block py-2 px-3 rounded-lg hover:bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <!-- Texto principal em #171717 -->
                                        <div class="text-sm font-bold text-[#171717]" x-text="formatCep(item.cep)"></div>
                                        <!-- Município em cinza -->
                                        <div class="text-xs uppercase tracking-wide text-gray-500" x-text="item.municipio"></div>
                                    </div>
                                    <!-- Destaque em roxo padrão -->
                                    <div class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full"
                                        x-text="item.total_empresas + ' empresas'"></div>
                                </div>
                            </a>
                        </template>
                    </div>

                </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function cepBusca() {
        return {
            // CEP digitado pelo usuário (com máscara)
            cepDigitado: '',
            // CEP sem máscara, apenas dígitos
            cepLimpo: '',
            // Flag indicando se o CEP possui 8 dígitos completos
            valido: false,
            // Mensagem exibida abaixo do campo de texto
            mensagem: 'Digite pelo menos 2 dígitos para iniciar a busca.',
            // Lista de resultados retornada pela API
            results: [],
            // Formata o CEP digitado e chama a busca quando apropriado
            formatar() {
                this.cepLimpo = this.cepDigitado.replace(/\D/g, '').slice(0, 8);
                if (this.cepLimpo.length > 5) {
                    this.cepDigitado = `${this.cepLimpo.slice(0, 5)}-${this.cepLimpo.slice(5)}`;
                } else {
                    this.cepDigitado = this.cepLimpo;
                }
                this.valido = this.cepLimpo.length === 8;
                this.mensagem = this.valido
                    ? 'CEP completo. Selecione um resultado abaixo.'
                    : 'Digite pelo menos 2 dígitos para iniciar a busca.';
                if (this.cepLimpo.length >= 2) {
                    this.buscar();
                } else {
                    this.results = [];
                }
            },
            // Realiza a requisição ao backend para obter resultados
            async buscar() {
                try {
                    const url = `{{ route('ceps.search') }}?q=${this.cepLimpo}`;
                    const resposta = await fetch(url);
                    if (resposta.ok) {
                        this.results = await resposta.json();
                    }
                } catch (erro) {
                    console.error('Erro ao buscar CEPs:', erro);
                }
            },
            // Gera a rota show para um determinado CEP
            routeShow(cep) {
                const base = `{{ route('ceps.show', ['cep' => '__CEP__']) }}`;
                return base.replace('__CEP__', cep);
            },
            // Formata uma string de CEP sem máscara para o formato 00000-000
            formatCep(cep) {
                if (!cep) return '';
                return `${cep.slice(0, 5)}-${cep.slice(5)}`;
            },
        };
    }
</script>
@endpush
