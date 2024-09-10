<?php

namespace App\Models;

use App\Http\Resources\UsuarioExportResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'email',
        'telefone',
        'cep',
        'estado',
        'bairro',
        'endereco',
        'status',
    ];
}
