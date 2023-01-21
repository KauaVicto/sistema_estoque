<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use \Psr\Http\Message\ResponseInterface as Response;

final class JWTAuth
{
    
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
        
        $response->getBody()->write('BEFORE' . $existingContent);

        return $response->withStatus(401);
    }
}
