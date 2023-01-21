<?php


use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {

    $app->post('/login', 'App\Controller\UsuarioController:login');

    $app->group('/produtos', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controller\ProdutoController:show')
            ->add(
                new JwtAuthentication([
                    'secret' => $_ENV['JWT_SECRET_KEY'],
                    'attribute' => 'jwt'
                ])
            );


        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:find');

        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert');


        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update');
    });

    $app->group('/pessoa', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\PessoaController:insert');
    });
};
