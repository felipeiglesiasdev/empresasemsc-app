@props(['ceps'])

<section class="py-16 sm:py-24 bg-slate-50 relative overflow-hidden">
    {{-- Elemento decorativo de fundo (opcional) --}}
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-indigo-200 to-transparent"></div>

    <div class="container mx-auto px-4 relative z-10">
        
        {{-- Cabeçalho Centralizado --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wide mb-4">
                Localizações Ativas
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                CEPs com Alta Atividade em <span class="text-indigo-600">SC</span>
            </h2>
            <p class="text-lg text-gray-600">
                Descubra regiões estratégicas de Joinville, Florianópolis e Blumenau onde o comércio está aquecido.
            </p>
        </div>

        {{-- Grid de Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($ceps as $cep)
                {{-- 
                    TRANSFORMADO EM LINK (<a>) 
                    Aponta para a rota individual do CEP
                --}}
                <a href="{{ route('ceps.show', ['cep' => $cep->cep]) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-200 hover:border-indigo-300 transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1 block text-left cursor-pointer">
                    
                    {{-- Cabeçalho do Card --}}
                    <div class="p-6 flex items-start justify-between">
                        <div class="flex items-center gap-4">
                            {{-- Ícone com destaque --}}
                            <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform duration-300">
                                <i class="bi bi-geo-alt-fill text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-0.5">CEP</p>
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight">{{ $cep->cep_formatado }}</h3>
                            </div>
                        </div>

                        {{-- 
                            Botão de Copiar 
                            Adicionado event.preventDefault() para não abrir o link do card ao clicar no botão
                            Adicionado cursor-pointer explícito
                        --}}
                        <button onclick="event.preventDefault(); navigator.clipboard.writeText('{{ $cep->cep_formatado }}'); const el = this; el.innerHTML = '<i class=\'bi bi-check-lg\'></i>'; setTimeout(() => el.innerHTML = '<i class=\'bi bi-clipboard\'></i>', 2000);" 
                            class="text-gray-400 hover:text-indigo-600 p-2 rounded-lg hover:bg-indigo-50 transition-colors cursor-pointer relative z-20" 
                            title="Copiar CEP">
                            <i class="bi bi-clipboard text-lg"></i>
                        </button>
                    </div>

                    {{-- Corpo do Card (Endereço) --}}
                    <div class="px-6 pb-6 flex-grow">
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-gray-700 font-medium text-lg leading-snug mb-4 min-h-[3.5rem] line-clamp-2" title="{{ $cep->tipo_logradouro }} {{ $cep->logradouro }}">
                                {{ $cep->tipo_logradouro }} {{ $cep->logradouro }}
                            </p>
                            
                            <div class="flex flex-wrap gap-2 mt-auto">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-semibold">
                                    <i class="bi bi-signpost-2 mr-1.5"></i>
                                    {{ Str::limit($cep->bairro, 20) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                    <i class="bi bi-building mr-1.5"></i>
                                    {{ $cep->municipioRel->descricao ?? 'SC' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Rodapé/Ação --}}
                    <div class="bg-gray-50 px-6 py-3 rounded-b-2xl border-t border-gray-100 flex justify-between items-center group-hover:bg-indigo-50/50 transition-colors">
                        <span class="text-xs font-bold text-green-600 flex items-center gap-1">
                            <i class="bi bi-graph-up-arrow"></i>
                            {{ number_format($cep->total_empresas ?? 0, 0, ',', '.') }} empresas ativas
                        </span>
                        <span class="text-indigo-600 text-sm font-bold group-hover:translate-x-1 transition-transform">
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Botão de Ação Principal (Rota Atualizada) --}}
        <div class="mt-16 text-center">
            <a href="{{ route('ceps.index') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-full text-white bg-gray-900 hover:bg-indigo-600 shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="bi bi-map mr-2"></i>
                Consultar Outros CEPs em SC
            </a>
        </div>

    </div>
</section>