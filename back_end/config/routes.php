<?php

use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {

    $app->group('/login', function (RouteCollectorProxy $group) {

        $group->post('', 'App\Controller\UsuarioController:login')->setName('login');
    
        $group->post('/verificar', 'App\Controller\UsuarioController:verificarLogin')->setName('verifyLogin');
    });
    
    $app->group('/produto', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controller\ProdutoController:showAll')->setName('listAllProducts');

        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:findById')->setName('findProductById');

        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert')->setName('insertProduct');

        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update')->setName('updateProduct');

        $group->delete('/deletar/{id:[0-9]+}', 'App\Controller\ProdutoController:delete')->setName('deleteProduct');


        $group->get('/estoques/{product_id:[0-9]+}', 'App\Controller\EstoqueController:findByProduct')->setName('stocksFindByProduct');
    });

    $app->group('/estoque', function (RouteCollectorProxy $group) {

        $group->get('', 'App\Controller\EstoqueController:showAll')->setName('showAllStock');

        $group->post('/cadastrar', 'App\Controller\EstoqueController:insert')->setName('insertStock');
    });

    $app->group('/pessoa', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\PessoaController:insert')->setName('insertPerson');
    });

    $app->group('/venda', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\VendaController:insert')->setName('insertSale');
        $group->post('/inserir_produto', 'App\Controller\VendaController:insertProduct')->setName('insertProductSale');
    });
};
