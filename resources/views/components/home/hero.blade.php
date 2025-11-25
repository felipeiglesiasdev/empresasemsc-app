<section class="relative bg-white overflow-hidden">
    {{-- Background com gradiente suave roxo --}}
    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-white to-purple-50 opacity-70 -z-10"></div>
    
    {{-- Elemento decorativo (círculo desfocado) --}}
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-4 pt-20 pb-24 sm:pt-32 sm:pb-40 text-center relative z-10">
        
        {{-- Badge --}}
        <div class="inline-flex items-center px-3 py-1 rounded-full border border-purple-200 bg-purple-50 text-purple-700 text-xs font-medium mb-8 shadow-sm">
            <span class="flex h-2 w-2 rounded-full bg-purple-600 mr-2"></span>
            Dados atualizados de empresas em SC
        </div>

        {{-- Título H1 Otimizado --}}
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 tracking-tight mb-6">
            Busque por <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Empresas em Santa Catarina</span>
        </h1>

        {{-- Subtítulo --}}
        <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto mb-12 leading-relaxed">
            A ferramenta mais completa para consultar CNPJs, verificar a situação cadastral e analisar o mercado catarinense.
        </p>

        {{-- Formulário de Busca --}}
        <div class="max-w-2xl mx-auto">
            <form action="{{ route('cnpj.consultar') }}" method="POST" class="relative group">
                @csrf
                
                {{-- Sombra Colorida no Hover --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                
                <div class="relative flex items-center bg-white rounded-xl p-2 shadow-lg border border-gray-100">
                    <div class="pl-4 text-gray-400">
                        <i class="bi bi-search text-xl"></i>
                    </div>
                    <input 
                        type="tel" 
                        name="cnpj" 
                        id="cnpj-hero-input"
                        class="w-full py-4 px-4 text-gray-800 text-lg bg-transparent border-none focus:ring-0 focus:outline-none placeholder-gray-400"
                        placeholder="Digite o CNPJ para consultar..."
                        required
                    >
                    <button type="submit" class="cursor-pointer hidden sm:flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-200 shadow-md transform hover:-translate-y-0.5">
                        Consultar
                    </button>
                </div>
                
                {{-- Botão Mobile (aparece apenas em telas pequenas) --}}
                <button type="submit" class="cursor-pointer mt-3 w-full sm:hidden bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 rounded-xl shadow-lg transition-colors">
                    Consultar CNPJ
                </button>
            </form>

            {{-- Mensagem de Erro --}}
            @if(session('error'))
                <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center justify-center text-red-600 animate-fade-in-up">
                    <i class="bi bi-exclamation-circle-fill mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        {{-- Links Rápidos (Opcional, bom para UX) --}}
        <div class="mt-10 flex justify-center gap-4 text-sm text-gray-500">
            <span>Buscas populares:</span>
            <a href="{{ route('municipios.show', ['slug' => 'florianopolis']) }}" class="hover:text-purple-600 underline decoration-purple-300 decoration-2 underline-offset-2">Empresas em Florianópolis</a>
            <a href="{{ route('municipios.show', ['slug' => 'joinville']) }}" class="hover:text-purple-600 underline decoration-purple-300 decoration-2 underline-offset-2">Empresas em Joinville</a>
            <a href="{{ route('municipios.show', ['slug' => 'blumenau']) }}" class="hover:text-purple-600 underline decoration-purple-300 decoration-2 underline-offset-2">Empresas em Blumenau</a>
        </div>
    </div>
</section>

{{-- Script para máscara do input --}}
@once
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/7.1.3/imask.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const heroInput = document.getElementById('cnpj-hero-input');
            if (heroInput) {
                IMask(heroInput, { mask: '00.000.000/0000-00' });
            }
        });
    </script>
    @endpush
@endonce