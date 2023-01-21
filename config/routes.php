<?php

use App\Middlewares\JWTAuth;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;


use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {


    $app->post('/login', 'App\Controller\UsuarioController:login');

    $app->post('/login/verificar', 'App\Controller\UsuarioController:verificarLogin');

    $app->group('/produtos', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controller\ProdutoController:show');

        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:find');

        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert');


        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update');
    })
        ->add('App\Middlewares\JWTAuth:jwtVerify');

    $app->group('/pessoa', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\PessoaController:insert');
    });
};
