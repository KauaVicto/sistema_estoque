<?php

namespace App\Middlewares;

use DateTime;
use Firebase\JWT\ExpiredException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JWTAuth extends \App\Controller\Controller
{

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $token = $request->getAttribute('jwt');
        $expDate = new DateTime($token['exp']);
        $nowDate = new DateTime('now');

        if ($expDate < $nowDate){
            $response = new Response();
            return self::view(['msg' => 'O token de acesso expirou'], $response, 401);
        }

        $response = $handler->handle($request);

        return $response;
    }
}
