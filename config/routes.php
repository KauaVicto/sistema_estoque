<?php

use Slim\Routing\RouteCollectorProxy;
use Slim\App;


return function (App $app) {

    $app->post('/login', 'App\Controller\UsuarioController:login');

    $app->group('/produtos', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controller\ProdutoController:show');
        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:find');
        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert');
        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update');
    });

    $app->group('/pessoa', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\PessoaController:insert');
    });
};
