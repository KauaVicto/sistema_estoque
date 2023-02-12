<?php

use Nyholm\Psr7\Response;
use Slim\App;
use Slim\Routing\RouteContext;
use Tuupola\Middleware\CorsMiddleware;
use App\Autentication\AuthJwt;

return function (App $app) {

    // auth jwt
    $app->add(function ($request, $handler) {

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $routesFree = ['login', 'verifyLogin'];

        if (!in_array($route->getName(), $routesFree)) {
            $token = $request->getHeaderLine('Authorization');
            $tokenSimple = str_replace('Bearer ', '', $token);

            $payload = AuthJwt::validateToken($tokenSimple);

            if (!$payload) {
                $response = new Response();
                return $response->withStatus(401);
            }

            if (is_object($payload)) {
                $role = $payload->role;

                if (!verifyAccess($role, $route->getName())) {
                    $response = new Response();
                    return $response->withStatus(401);
                }
            }
        }


        return $handler->handle($request);
    });

    // define cors

    
    
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Handle exceptions
    $app->addErrorMiddleware(true, true, true);


    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
};
