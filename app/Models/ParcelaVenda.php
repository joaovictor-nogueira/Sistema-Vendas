<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelaVenda extends Model
{
    protected $table = "parcelas_vendas";

    protected $fillable = [ "venda_id", "numero","valor","data","observacao" ];

    protected $casts = [
        'data' => 'datetime',
       
    ];
}
