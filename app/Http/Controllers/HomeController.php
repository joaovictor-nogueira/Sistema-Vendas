<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vendas = Venda::all();

        $valorTotalVendas = $vendas->sum('valor_total');
        
        $vendasTotais = $vendas->count();

        $clientes = Cliente::all();
        $clientesTotais= $clientes->count();
        
        $produtos = Produto::all();
        $produtosTotais = $produtos->count();

        return view('home', compact('valorTotalVendas','vendasTotais', 'clientesTotais', 'produtosTotais'));
    }
}
