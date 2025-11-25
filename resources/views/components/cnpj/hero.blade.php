@props(['data'])

<section class="bg-indigo-900 pt-12 pb-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-xs font-medium text-indigo-300" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Início</a></li>
                <li><span class="mx-1">/</span></li>
                <li><span class="text-white">CNPJ {{ $data['cnpj_completo'] }}</span></li>
            </ol>
        </nav>

        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 shadow-xl">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    {{-- Badges de Status --}}
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border
                            {{ $data['situacao_cadastral'] == 'ATIVA' ? 'bg-green-500/20 text-green-300 border-green-500/30' : 'bg-red-500/20 text-red-300 border-red-500/30' }}">
                            {{ $data['situacao_cadastral'] }}
                        </span>
                        <span class="px-3 py-1 rounded-full bg-indigo-800/50 text-indigo-200 text-xs font-bold uppercase tracking-wide border border-indigo-700">
                            {{ $data['matriz_ou_filial'] }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight mb-1">
                        {{ $data['razao_social'] }}
                    </h1>
                    @if($data['nome_fantasia'])
                        <p class="text-lg text-indigo-200 font-medium mt-1">
                            Fantasia: <span class="text-white">{{ $data['nome_fantasia'] }}</span>
                        </p>
                    @endif
                </div>

                {{-- CNPJ em destaque --}}
                <div class="md:text-right mt-4 md:mt-0">
                    <p class="text-xs text-indigo-300 uppercase font-bold tracking-wider mb-1">Número de Inscrição</p>
                    <p class="text-2xl font-mono font-bold text-white">{{ $data['cnpj_completo'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>