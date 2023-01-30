<?php


use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {


    $app->post('/login', 'App\Controller\UsuarioController:login');

    $app->post('/login/verificar', 'App\Controller\UsuarioController:verificarLogin');

    $app->group('/produto', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controller\ProdutoController:showAll');

        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:findById');

        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert')->setName('cadastrar_produto');


        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update');
    });

    $app->group('/pessoa', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\PessoaController:insert');
    });
};
