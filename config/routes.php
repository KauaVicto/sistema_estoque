<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Http\Response;

use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {

    $app->post('/login', 'App\Controller\UsuarioController:login');

    $app->group('/produtos', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controller\ProdutoController:show');

        $group->get('/{id:[0-9]+}', 'App\Controller\ProdutoController:find');

        $group->post('/cadastrar', 'App\Controller\ProdutoController:insert');


        $group->put('/alterar/{id:[0-9]+}', 'App\Controller\ProdutoController:update');
    })
        ->add(function (Request $request, RequestHandler $handler) {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();

            $response = new Response();
            $response->getBody()->write('BEFORE' . $existingContent);

            return $response;
        })
        ->add(
            new JwtAuthentication([
                'secret' => $_ENV['JWT_SECRET_KEY'],
                'attribute' => 'jwt'
            ])
        );

    $app->group('/pessoa', function (RouteCollectorProxy $group) {
        $group->post('/cadastrar', 'App\Controller\PessoaController:insert');
    });
};
