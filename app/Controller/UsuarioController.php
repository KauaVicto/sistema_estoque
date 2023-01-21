<?php

namespace App\Controller;

use App\Entity\Usuario;
use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;
use Firebase\JWT\JWT;

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
                return self::view(['msg' => 'Usuario nao encontrado'], $response, 401);
            }

            $objUsuario = $usuario[0];

            /* Verifica se a senha está correta */
            if (!password_verify($params['senha'], $objUsuario->getSenha())) {
                return self::view(['msg' => 'Senha Incorreta'], $response, 401);
            }

            /* Gera o token de acesso */

            $tokenPayload = [
                'sub' => $objUsuario->getId(),
                'user' => $objUsuario->getUsuario(),
                'nivel_acesso' => $objUsuario->getNivelAcesso(),
                'exp' => time() + 10000,
                'iat' => time()
            ];

            $token = JWT::encode($tokenPayload, $_ENV['JWT_SECRET_KEY'], 'HS256');


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
        $request->getHeader('Authrization');

        return self::view(['msg' => 'O usuário está logado'], $response, 200);
    }
}
