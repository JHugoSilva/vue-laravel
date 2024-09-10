<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $enderecoFormatar = explode(',', $this->endereco);

        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "cpf" => formatarCpf($this->cpf),
            "data_nascimento" => $this->data_nascimento,
            "email" => $this->email,
            "telefone" => formatarTelefone($this->telefone),
            "cep" => formatarCep($this->cep),
            "estado" => $this->estado,
            "bairro" => $this->bairro,
            "endereco" =>  $enderecoFormatar[0] ?? $this->endereco,
            "numero" =>  $enderecoFormatar[1] ?? $this->endereco,
            "status" => $this->status,
        ];
    }
}
