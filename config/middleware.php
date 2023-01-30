<?php

use Nyholm\Psr7\Response;
use Slim\App;
use Slim\Routing\RouteContext;
use App\Autentication\AuthJwt;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Handle exceptions
    $app->addErrorMiddleware(true, true, true);

    $app->add(function ($request, $handler) {
        $route = $request->getServerParams()['REQUEST_URI'];
        $routes = ['/produto'];

        if (in_array($route, $routes)) {
            $token = $request->getHeaderLine('Authorization');
            $tokenSimple = str_replace('Bearer ', '', $token);
            if (!AuthJwt::validateToken($tokenSimple)) {
                $response = new Response();
                return $response->withStatus(401);
            }
        }
        return $handler->handle($request);
    });
};
