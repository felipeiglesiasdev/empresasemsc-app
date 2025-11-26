@extends('layouts.app')

@section('content')
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Solicitação de Remoção</h1>
                <p class="text-gray-600 mt-2">
                    Se você é o titular ou representante legal do CNPJ abaixo e deseja solicitar a retirada dos dados do nosso site, por favor preencha o formulário. Analisaremos a solicitação e entraremos em contato para informar os próximos passos.
                </p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800 mb-1">CNPJ a ser removido</h2>
                    <p class="font-mono text-indigo-700 text-xl">{{ $cnpjFormatado }}</p>
                </div>

                <form method="POST" action="{{ route('remocao.store', ['cnpj' => $cnpj]) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700">Seu nome</label>
                        <input type="text" name="nome" id="nome" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                               placeholder="Nome do solicitante">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail para contato</label>
                        <input type="email" name="email" id="email" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                               placeholder="seu@email.com">
                    </div>
                    <div>
                        <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo da solicitação</label>
                        <textarea name="motivo" id="motivo" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                                  placeholder="Descreva por que deseja remover este CNPJ do nosso site"></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition-colors">
                            Enviar solicitação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
