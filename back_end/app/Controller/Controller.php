<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

abstract class Controller
{
    /**
     * Método responsável por retornar a resposta
     * @param array $data
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function view($data, ResponseInterface $response, int $statusCode=200)
    {
        $response->getBody()->write(json_encode($data));

        return $response->withStatus($statusCode)->withHeader('content-type', 'application/json');
    }
}
