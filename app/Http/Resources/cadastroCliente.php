<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class cadastroCliente extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)//: array
    {
        return [
            'nome'     => $this->nome,
            'email'    => $this->email,
            'rg'       => $this->rg,
            'cpf_cnpj' => $this->cpf_cnpj,
            'data_nascimento' => $this->data_nascimento,
            'telefone'        => $this->telefone,
            'estado_civil'    => $this->estado_civil,
            'sexo'   => $this->sexo,
            'cep'    => $this->cep,
            'estado' => $this->estado,
            'cidade' => $this->cidade,
            'bairro' => $this->bairro,
            'rua'    => $this->rua,
            'complemento' => $this->complemento
          ];

        //return parent::toArray($request);
    }
}
