<?php

namespace App\Controller;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;

class UsuarioController extends Controller
{
    public function insert(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {
            $params = $request->getParsedBody();

            $pessoa = new \App\Entity\Pessoa();
            $pessoa->setNome($params['nome']);
            $pessoa->setCpf($params['cpf']);

            $objDateTime = new DateTime($params['data_nasc']);
            
            $pessoa->setData_Nasc($objDateTime);
            
            $entityManager->persist($pessoa);
            $entityManager->flush();

            return self::view(['id' => $pessoa->getId()], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }
}