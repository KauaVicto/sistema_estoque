<?php

namespace App\Middlewares;

use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

final class JwtDatetimeMiddleware
{
    
    public function __invoke(Request $request, Response $response): Response
    {
        $token = $request->getAttribute('jwt');
        $expireDate = new \DateTime($token['expired_at']);
        $nowDate = new \DateTime('now');
/* 
        if ($nowDate <= $expireDate) {
        } */
        return $response->withStatus(401);
        return $response;
    }
}
