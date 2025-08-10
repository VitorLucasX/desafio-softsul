<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */ //
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome_cliente' => $this->nome_cliente,
            'data_pedido' => $this->data_pedido->format('Y-m-d'),
            'data_entrega' => $this->data_entrega ? $this->data_entrega->format('Y-m-d') : null,
            'status' => $this->status,
        ];
    }
}