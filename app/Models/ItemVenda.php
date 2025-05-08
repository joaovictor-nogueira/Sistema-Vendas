<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    protected $table = "itens_vendas";

    protected $fillable = ["venda_id", "produto_id", 'quantidade', 'preco_unitario', 'total'];

    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
