<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "cpf" => formatarCpf($this->cpf),
            "data_nascimento" => formatarDataPtBr($this->data_nascimento),
            "email" => $this->email,
            "telefone" => formatarTelefone($this->telefone),
            "cep" => formatarCep($this->cep),
            "estado" => $this->estado,
            "bairro" => $this->bairro,
            "endereco" =>  $this->endereco,
            "status" => $this->status,
        ];
    }
}
