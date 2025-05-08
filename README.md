# Sistema de Vendas

Este é um sistema web de vendas desenvolvido em Laravel. O objetivo do projeto é permitir o gerenciamento básico de vendas, produtos e clientes de forma simples e eficiente.

## Funcionalidades

- Cadastro de produtos  
- Cadastro de clientes  
- Registro de vendas  
- Associação de produtos a uma venda  
- Controle de valores e formas de pagamento  

## Tecnologias utilizadas

- PHP 8.x  
- Laravel 10/11  
- MySQL  
- Bootstrap ou Tailwind CSS  
- Blade (motor de templates do Laravel)  

## Como rodar o projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/joaovictor-nogueira/seu-repo.git
   ```
2. Instale as dependências: 
   ```bash
    composer install
    npm install && npm run dev
   ```
3. Configure o arquivo .env:
   ```bash
    cp .env.example .env
    php artisan key:generate
   ```
4. Rode as migrations.
   ```bash
    php artisan migrate
   ```
5. Inicie o servidor
   ```bash
    php artisan serve
   ```

---
Desenvolvido por João Victor N. Doratioto
