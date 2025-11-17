
@extends('layouts.app')
@push('seo_tags')
    @include('components.cnpj.tags', ['data' => $data])
@endpush


@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 ">
            <main class="lg:col-span-8 mt-12 space-y-8">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                         <a href="https://apretailer.com.br/click/69121abf2bfa811e621de642/187685/356381/subaccount" target="_blank" rel="nofollow sponsored" title="Anúncio Santander">
                            <img src="{{ asset('images/santander-ads.webp') }}" alt="Anúncio Santander" class="w-full h-auto">
                        </a>
                </div>
                <x-cnpj.intro-text :data="$data" />
                <x-cnpj.informacoes-cnpj :data="$data" />
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                         <a href="https://apretailer.com.br/click/69121abf2bfa811de9451f82/184280/356381/subaccount" target="_blank" rel="nofollow sponsored" title="Anúncio Blaze">
                            <img src="{{ asset('images/blaze-ads.webp') }}" alt="Anúncio Blaze" class="w-full h-auto">
                        </a>
                </div>
                <x-cnpj.situacao-cadastral :data="$data" />
                <x-cnpj.atividades-economicas :data="$data" />
                <x-cnpj.endereco :data="$data" />
                <x-cnpj.contato :data="$data" />
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                         <a href="https://apretailer.com.br/click/69121abf2bfa811dfb2fa647/183619/356381/subaccount" target="_blank" rel="nofollow sponsored" title="Anúncio Hostinger">
                            <img src="{{ asset('images/hostinger-ads2.webp') }}" alt="Anúncio Hostinger" class="w-full h-auto">
                        </a>
                </div>
                <x-cnpj.qsa :data="$data" />
                <x-cnpj.empresas-semelhantes :data="$data" />
                <p>Caso queira solicitar a remoção desse CNPJ de nosso site, <a href="https://wa.me/+5532998620167?text=Ol%C3%A1%2C%20gostaria%20de%20solicitar%20a%20remo%C3%A7%C3%A3o%20de%20um%20CNPJ!" class="text-[#ED1C24] hover:underline font-medium" target="_blank" rel="noopener nofollow">clique aqui</a>.</p>
                <x-lgpd />
            </main>
            
            {{-- Barra Lateral --}}
            <aside class="lg:col-span-4 mt-12 lg:mt-0">
                <div class="mt-12 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Nova Consulta</h2>
                    <p class="text-gray-600 mb-6">Deseja consultar outro CNPJ?</p>
                    <form action="{{ route('cnpj.consultar') }}" method="POST" novalidate>
                        @csrf
                        <div class="relative w-full mb-4">
                           <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                               <i class="bi bi-search text-gray-400"></i>
                           </div>
                            <input 
                                type="tel" 
                                name="cnpj" 
                                id="cnpj-input-aside" 
                                class="w-full text-lg pl-12 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#ed1c24]/50 focus:border-[#ed1c24] transition-colors duration-300" 
                                placeholder="00.000.000/0000-00"
                                required>
                        </div>
                        <button type="submit" class="cursor-pointer w-full bg-[#ed1c24] text-white font-bold py-3 px-6 rounded-lg text-lg hover:bg-[#c11b21] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#ed1c24]/50 flex items-center justify-center gap-2">
                            <span>Consultar</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>
                </div>
                <div class="mt-12">
                         <a href="https://apretailer.com.br/click/69121abf2bfa811e621de642/187685/356381/subaccount" target="_blank" rel="nofollow sponsored" title="Anúncio Santander">
                            <img src="{{ asset('images/santander-ads2.webp') }}" alt="Anúncio Santander" class="w-full h-auto">
                        </a>
                </div>
                <div class="mt-12">
                         <a href="https://apretailer.com.br/click/69121abf2bfa811dfb2fa647/183619/356381/subaccount" target="_blank" rel="nofollow sponsored" title="Anúncio Hostinger">
                            <img src="{{ asset('images/hostinger-ads.webp') }}" alt="Anúncio Hostinger" class="w-full h-auto">
                        </a>
                </div>
                <div class="mt-12">
                         <a href="https://ton.com.br/catalogo/?referrer=7DAD1277-705A-43A8-A1FC-AE8E48A7F304&userAnticipation=0&utm_medium=invite_share&utm_source=revendedor" target="_blank" rel="nofollow sponsored" title="Anúncio Ton">
                            <img src="{{ asset('images/ton-ads.webp') }}" alt="Anúncio Ton" class="w-full h-auto">
                        </a>
                </div>
            </aside>
        </div>
        @if(session('error'))
            <x-popup-error message="{{ session('error') }}" title="Ocorreu um Erro" />
        @endif
    </div>
</div>
<div align="center">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3006074386164387"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-3006074386164387"
     data-ad-slot="8361208921"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
@endsection

@push('scripts')
{{-- Máscara para o campo de CNPJ na barra lateral --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/7.1.3/imask.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cnpjInput = document.getElementById('cnpj-input-aside');
        if (cnpjInput) {
            const mask = IMask(cnpjInput, { mask: '00.000.000/0000-00' });
            const form = cnpjInput.closest('form');
            if (form) {
                form.addEventListener('submit', function() { mask.updateValue(); });
            }
        }
    });
</script>
@endpush


