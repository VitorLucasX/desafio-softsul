<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_cliente',
        'data_pedido',
        'data_entrega',
        'status',
    ];

    protected $casts = [
        'data_pedido' => 'date',
        'data_entrega' => 'date',
    ];
}