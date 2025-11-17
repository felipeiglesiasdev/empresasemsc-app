<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoRemocao extends Model
{
    use HasFactory;
    protected $table = 'solicitacoes_remocao';
    protected $fillable = [
        'cnpj',
        'razao_social',
        'email_solicitante',
        'nome_solicitante',
        'motivo',
        'status',
    ];
}