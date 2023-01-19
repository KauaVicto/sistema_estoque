<?php

use Slim\Routing\RouteCollectorProxy;
use Slim\App;


return function (App $app) {

    $app->group('/produtos', function(RouteCollectorProxy $group){
        $group->get('', 'App\Controller\ProdutoController:show');
        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:find');
        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert');
        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update');
    });

};
