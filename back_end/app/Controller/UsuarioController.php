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

            $token = AuthJwt::generateToken($objUsuario->getId(), $objUsuario->getNivelAcesso());

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

        $payload = AuthJwt::validateToken($tokenSimple);

        if (!$payload){
            return self::view(['msg' => 'Token inválido'], $response, 401);
        }

        if (is_object($payload)) {
            return self::view(['role' => $payload->role], $response, 200);
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {
            $params = $request->getParsedBody();
            $usuarioId = $args['id'];

            $usuario = $entityManager->getRepository('App\Entity\Usuario')->find($usuarioId);
            
            if (!$usuario){
                return self::view(['detail' => 'Usuário não encontrado'], $response, 404);
            }
            
            if (!password_verify($params['senha_antiga'], $usuario->getSenha())){
                return self::view(['detail' => 'Senha antiga incorreta'], $response, 404);
            }

            $usuario->setUsuario($params['usuario']);
            $usuario->setSenha(password_hash($params['senha'], PASSWORD_ARGON2I));

            $entityManager->persist($usuario);
            $entityManager->flush();

            return self::view(['id' => $usuario->getId()], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }
}
