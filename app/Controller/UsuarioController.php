<?php

namespace App\Controller;

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
            $expiredAt = (new DateTime())->modify('+2 days')->format('Y-m-d H:i:s');
            
            $tokenPayload = [
                'sub' => $objUsuario->getId(),
                'user' => $objUsuario->getUsuario(),
                'expired_at' => $expiredAt,
            ];

            $token = JWT::encode($tokenPayload, $_ENV['JWT_SECRET_KEY']);
            $refreshTokenPayload = [
                'user' => $objUsuario->getUsuario()
            ];
            $refreshToken = JWT::encode($refreshTokenPayload, $_ENV['JWT_SECRET_KEY']);

            \App\Model\Token::saveToken([
                'token' => $token,
                'refresh_token' => $refreshToken,
                'expired_at' => $expiredAt,
                'usuario' => $objUsuario->getId()
            ]);

            
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 401);
        }
    }
}
