<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Classes\Contas;

return function (App $app) {

    $app->get('/home', function (ServerRequestInterface $request, ResponseInterface $response) {

        $response->getBody()->write(json_encode(["nome" => "Layla"]));

        return $response->withStatus(200)->withHeader('content-type', 'application/json');
    });

    
};