REQUISITOS: Git, Composer, Mysql 8.0.29, PHP 8.0.19, Extensões do PHP (pdo_mysql)


CONFIGURAÇÃO DO AMBIENTE:

Pegar o projeto com o Git

Criar a base de dados (base vazia para rodar as migrations) 

Criar o .env do projeto partindo do .env.example e inserir as configurações do banco de dados

Instalar o Laravel "composer global require laravel/installer"

Na pasta do projeto, rodar: "composer install"

Rodar: "php artisan key:generate"

Rodar: "php artisan migrate"

E depois subir o server com: "php artisan serve"


TESTE:

Abrir o navegador no endereço que o servidor subiu, irá abri o swagger para testar a API
