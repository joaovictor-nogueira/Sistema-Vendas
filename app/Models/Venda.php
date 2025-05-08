<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = "vendas";

    protected $fillable = ["cliente_id", "user_id", "valor_total", "tipo_pagamento", "forma_pagamento"];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itens()
    {
        return $this->hasMany(ItemVenda::class, 'venda_id');
    }

    public function parcelas()
    {
        return $this->hasMany(ParcelaVenda::class,'venda_id');
    }
}
