@props(['data'])

{{-- Card de dados públicos e solicitação de remoção --}}
<div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
    <div class="flex items-start gap-3">
        <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
            <i class="bi bi-info-circle text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-lg text-gray-900 mb-1">Dados públicos e remoção</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                Todas as informações exibidas nesta página são de natureza pública, de acordo com a
                legislação brasileira (Lei da Transparência, Lei de Acesso à Informação e bases governamentais).
                Caso você seja o proprietário deste CNPJ e deseje solicitar a remoção destes dados do nosso site,
                clique no botão abaixo.
            </p>
            <a
                href="{{ route('remocao.cnpj', ['cnpj' => str_replace(['.', '/', '-'], '', $data['cnpj_completo'])]) }}"
                class="inline-flex items-center px-4 py-2 mt-4 border border-indigo-600 text-indigo-600 rounded-lg
                       hover:bg-indigo-600 hover:text-white transition-colors font-bold text-sm"
            >
                Solicitar Remoção
            </a>
        </div>
    </div>
</div>
