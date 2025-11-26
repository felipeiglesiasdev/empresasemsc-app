<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador responsável por exibir e processar solicitações de remoção de dados de CNPJ.
 */
class RemocaoController extends Controller
{
    /**
     * Mostra o formulário de solicitação de remoção de dados.
     *
     * @param  string  $cnpj  CNPJ sem formatação.
     * @return \Illuminate\View\View
     */
    public function create(string $cnpj)
    {
        // Formata o CNPJ para exibição (ex: 12345678000190 -> 12.345.678/0001-90)
        $cnpjFormatado = vsprintf('%s.%s.%s/%s-%s', [
            substr($cnpj, 0, 2), substr($cnpj, 2, 3), substr($cnpj, 5, 3),
            substr($cnpj, 8, 4), substr($cnpj, 12, 2),
        ]);

        return view('pages.remocao.create', [
            'cnpj' => $cnpj,
            'cnpjFormatado' => $cnpjFormatado,
        ]);
    }

    /**
     * Processa a solicitação de remoção.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cnpj
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, string $cnpj)
    {
        // TODO: implementar lógica de armazenamento da solicitação de remoção

        return redirect()
            ->route('home')
            ->with('success', 'Solicitação de remoção enviada com sucesso. Entraremos em contato em breve.');
    }
}
