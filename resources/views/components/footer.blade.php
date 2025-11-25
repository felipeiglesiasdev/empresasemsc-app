<footer class="bg-gray-900 text-white border-t border-indigo-900">
    <div class="container mx-auto px-4 pt-16 pb-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            {{-- Coluna 1: Sobre --}}
            <div class="space-y-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-lg font-bold">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                    <span class="text-xl font-black tracking-tight text-white">
                        EMPRESAS <span class="text-indigo-400">SC</span>
                    </span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed">
                    O maior portal de dados abertos empresariais de Santa Catarina. Consulte CNPJs, verifique a situação cadastral e analise o mercado local de forma 100% gratuita.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>
            </div>

            {{-- Coluna 2: Navegação --}}
            <div>
                <h3 class="text-lg font-bold mb-6 border-b border-gray-800 pb-2 inline-block text-white">Navegação</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Página Inicial</a></li>
                    <li><a href="{{ route('municipios.index') }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Lista de Municípios</a></li>
                    <li><a href="" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Consulta por CEP</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Estatísticas Estaduais</a></li>
                </ul>
            </div>

            {{-- Coluna 3: Cidades Principais (SEO) --}}
            <div>
                <h3 class="text-lg font-bold mb-6 border-b border-gray-800 pb-2 inline-block text-white">Principais Cidades</h3>
                <ul class="space-y-3">
                    {{-- Usando slugs fixos para as maiores cidades --}}
                    <li><a href="{{ route('municipios.show', ['slug' => 'joinville']) }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Empresas em Joinville</a></li>
                    <li><a href="{{ route('municipios.show', ['slug' => 'florianopolis']) }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Empresas em Florianópolis</a></li>
                    <li><a href="{{ route('municipios.show', ['slug' => 'blumenau']) }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Empresas em Blumenau</a></li>
                    <li><a href="{{ route('municipios.show', ['slug' => 'sao-jose']) }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Empresas em São José</a></li>
                    <li><a href="{{ route('municipios.show', ['slug' => 'chapeco']) }}" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Empresas em Chapecó</a></li>
                </ul>
            </div>

            {{-- Coluna 4: Legal --}}
            <div>
                <h3 class="text-lg font-bold mb-6 border-b border-gray-800 pb-2 inline-block text-white">Legal & Contato</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Política de Privacidade</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Termos de Uso</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors text-sm">Contato / Remover CNPJ</a></li>
                </ul>
                <div class="mt-6 p-4 bg-gray-800/50 rounded-xl border border-gray-800">
                    <p class="text-xs text-gray-500">
                        <i class="bi bi-info-circle mr-1"></i> Os dados exibidos neste site são públicos e obtidos através da base da Receita Federal do Brasil.
                    </p>
                </div>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm text-center md:text-left">
                &copy; {{ date('Y') }} Empresas SC. Todos os direitos reservados. Feito com <i class="bi bi-heart-fill text-indigo-500 text-xs mx-1"></i> em Santa Catarina.
            </p>
            <div class="flex items-center gap-6">
                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Segurança e Privacidade</span>
                <i class="bi bi-shield-check text-gray-600 text-xl"></i>
            </div>
        </div>

    </div>
</footer>