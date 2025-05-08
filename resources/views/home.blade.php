@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <div class="text-center">
                    <div>
                        <h1 class="fw-bold mb-1">Bem-vindo ao Painel</h1>
                        <p class="text-muted mb-0">Escolha uma das opções abaixo para continuar</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
       
        <div class="col-md-4">
            <div class="card border-0 h-100 shadow-hover">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 d-inline-block mb-3">
                        <i class="bi bi-cart-check-fill fs-2 text-primary"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Vendas</h3>
                    <p class="text-muted mb-4">Gerencie suas vendas.</p>
                    <a href="{{route('venda.index')}}" class="btn btn-outline-primary rounded-pill px-4">
                        Acessar <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card border-0 h-100 shadow-hover">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3 d-inline-block mb-3">
                        <i class="bi bi-box-seam-fill fs-2 text-success"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Produtos</h3>
                    <p class="text-muted mb-4">Cadastre e edite seus produtos.</p>
                    <a href="{{route('produto.index')}}" class="btn btn-outline-success rounded-pill px-4">
                        Acessar <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card border-0 h-100 shadow-hover">
                <div class="card-body p-4 text-center">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3 d-inline-block mb-3">
                        <i class="bi bi-people-fill fs-2 text-warning"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Clientes</h3>
                    <p class="text-muted mb-4">Visualize e edite informações dos clientes.</p>
                    <a href="{{route('cliente.index')}}" class="btn btn-outline-warning rounded-pill px-4">
                        Acessar <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>

   
   <!-- <div class="row mt-5">
        <div class="col-12">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h3 class="h5 fw-bold mb-3">Resumo do Mês</h3>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-currency-dollar text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Faturamento</p>
                                    <h4 class="mb-0 fw-bold">R$ 24.580</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-cart-check text-success"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Vendas</p>
                                    <h4 class="mb-0 fw-bold">156</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-person text-info"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Novos Clientes</p>
                                    <h4 class="mb-0 fw-bold">24</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="bi bi-box-seam text-danger"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Estoque Baixo</p>
                                    <h4 class="mb-0 fw-bold">8</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</div>

@endsection
