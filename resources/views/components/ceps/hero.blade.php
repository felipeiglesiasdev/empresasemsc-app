@props(['totalCeps', 'totalEmpresasEstado'])

<section class="bg-indigo-900 py-10 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
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

            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-white max-w-sm w-full" x-data="cepBusca()">
                <form class="space-y-3" @submit.prevent="redirecionar" @keyup.enter.prevent="redirecionar">
                    <div class="flex items-center gap-3">
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
                        <div class="mt-2 flex items-center gap-2">
                            <input
                                type="text"
                                x-model="cepDigitado"
                                @input="formatar()"
                                maxlength="9"
                                inputmode="numeric"
                                placeholder="00000-000"
                                class="w-full px-3 py-2 rounded-lg bg-white/20 border border-white/30 placeholder-indigo-200 text-white focus:outline-none focus:ring-2 focus:ring-white/60"
                            />
                            <button type="submit" class="px-4 py-2 bg-white text-indigo-900 font-bold rounded-lg disabled:opacity-40 disabled:cursor-not-allowed" :disabled="!valido">Buscar</button>
                        </div>
                        <p class="text-[11px] mt-1" :class="valido ? 'text-indigo-100' : 'text-red-200'" x-text="mensagem"></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function cepBusca() {
        return {
            cepDigitado: '',
            cepLimpo: '',
            valido: false,
            mensagem: 'Informe 8 dígitos ou use o formato 00000-000.',
            formatar() {
                this.cepLimpo = this.cepDigitado.replace(/\D/g, '').slice(0, 8);
                if (this.cepLimpo.length > 5) {
                    this.cepDigitado = `${this.cepLimpo.slice(0, 5)}-${this.cepLimpo.slice(5)}`;
                } else {
                    this.cepDigitado = this.cepLimpo;
                }
                this.valido = this.cepLimpo.length === 8;
                this.mensagem = this.valido
                    ? 'Pronto! Clique em buscar para ver as empresas do CEP.'
                    : 'Informe 8 dígitos ou use o formato 00000-000.';
                if (this.valido) {
                    this.redirecionar();
                }
            },
            redirecionar() {
                if (!this.valido) return;
                const url = `{{ route('ceps.show', ['cep' => '__CEP__']) }}`.replace('__CEP__', this.cepLimpo);
                window.location.href = url;
            },
        };
    }
</script>
