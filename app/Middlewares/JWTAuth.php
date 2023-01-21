<?php

namespace App\Middlewares;

use DateTime;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Tuupola\Middleware\JwtAuthentication;
use Firebase\JWT\JWT;

class JWTAuth extends \App\Controller\Controller
{

    public function jwtVerify(Request $request, RequestHandler $handler)
    {
        $authToken = $request->getHeader('Authorization');

        try {
            $token = str_replace('Bearer ', '', $authToken[0]);
            $decoded = JWT::decode($token, $_ENV['JWT_SECRET_KEY'], ['HS256']);

            $response = $handler->handle($request);

            return $response;
        } catch (\Throwable $e) {
            $response = new Response();
            return self::view(['msg' => $e->getMessage()], $response, 401);
        }
    }
}
