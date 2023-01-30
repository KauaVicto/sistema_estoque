<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;
use App\Autentication\AuthJwt;

class UsuarioController extends Controller
{
    public function login(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {

            $params = $request->getParsedBody();

            $usuarioRepository = $entityManager->getRepository('App\Entity\Usuario');
            $usuario = $usuarioRepository->findBy(['usuario' => $params['usuario']], limit: 1);

            /* Verifica se o usuário existe */
            if (count($usuario) == 0) {
                return self::view(['msg' => 'USUARIO NÃO ENCONTRADO'], $response, 401);
            }

            $objUsuario = $usuario[0];

            /* Verifica se a senha está correta */
            if (!password_verify($params['senha'], $objUsuario->getSenha())) {
                return self::view(['msg' => 'SENHA INCORRETA'], $response, 401);
            }

            $token = AuthJwt::generateToken($objUsuario->getId());

            return self::view([
                'token' => $token
            ], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 401);
        }
    }

    /**
     * Método responsável por verificar se a pessoa logada
     */
    public function verificarLogin(ServerRequestInterface $request, ResponseInterface $response)
    {
        $token = $request->getHeaderLine('Authorization');

        $tokenSimple = str_replace('Bearer ', '', $token);

        if (AuthJwt::validateToken($tokenSimple)) {
            return self::view(['msg' => 'O usuário está logado'], $response, 200);
        } else {
            return self::view(['msg' => 'Token inválido'], $response, 401);
        }
    }
}
