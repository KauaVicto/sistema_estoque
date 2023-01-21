<?php

namespace App\Controller;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;
use App\Utils\Utils;

class PessoaController extends Controller
{
    
    public function insert(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";


        try {

            $params = $request->getParsedBody();

            /* Cadastrando a pessoa */
            $pessoa = new \App\Entity\Pessoa();
            $pessoa->setNome(mb_strtoupper($params['nome'], 'utf-8'));
            $pessoa->setCpf($params['cpf']);

            $objDateTime = new DateTime($params['data_nasc']);

            $pessoa->setData_Nasc($objDateTime);

            
            $entityManager->persist($pessoa);
            $entityManager->flush();
            
            /* Cadastrando o usuário */
            $usuario = new \App\Entity\Usuario();
            
            $usuarioNome = explode(' ', $params['nome'])[0];
            $usuarioNomeSemAcento = Utils::removerAcentos($usuarioNome);
            $usuarioCompleto = strtolower($usuarioNomeSemAcento) . "_" . str_pad($pessoa->getId(), 3, '0', STR_PAD_LEFT);

            $usuario->setUsuario($usuarioCompleto);
            $usuario->setSenha(password_hash($params['cpf'], PASSWORD_ARGON2I));
            $usuario->setPessoa($pessoa);
            $usuario->setNivelAcesso(1);

            $entityManager->persist($usuario);
            $entityManager->flush();

            return self::view([
                'pessoa_id' => $pessoa->getId(),
                'usuario' => $usuarioCompleto,
                'senha' => $params['cpf']
            ], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {
            $params = $request->getParsedBody();
            $produtoId = $args['id'];

            $produto = $entityManager->getRepository('App\Entity\Produto')->find($produtoId);

            if (!$produto) {
                return self::view(['detail' => 'Produto não encontrado'], $response, 404);
            }

            $produto->setNome($params['nome']);
            $produto->setDescricao($params['descricao']);
            $produto->setValor($params['valor']);
            $produto->setCodigoBarras($params['codigo_barras'] ?? null);

            $entityManager->persist($produto);
            $entityManager->flush();

            return self::view(['id' => $produto->getId()], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }
}
