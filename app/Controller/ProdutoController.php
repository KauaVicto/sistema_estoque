<?php

namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;

class ProdutoController extends Controller
{
    /**
     * Método responsável por retornar todos os produtos do banco de dados
     */
    public function showAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        $productRepository = $entityManager->getRepository('App\Entity\Produto');
        $produtos = $productRepository->findBy([], ['id' => 'ASC']);

        $produtosArray = array_map(function ($e) {
            return $e->serialize();
        }, $produtos);

        return self::view($produtosArray, $response, 200);
    }

    /**
     * Método responsável por retornar um produto pelo seu id
     */
    public function findById(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        $produto = $entityManager->find('App\Entity\Produto', $args['id']);

        if (!is_null($produto)) {
            $produtoArray = $produto->serialize();
        } else {
            $produtoArray = [];
        }

        return self::view($produtoArray, $response, 200);
    }

    /**
     * Método responsável por inserir um produto no banco de dados
     */
    public function insert(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {

            $params = $request->getParsedBody();

            $produto = new \App\Entity\Produto();
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

    /**
     * Método responsável por alterar um produto no banco de dados
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {
            $params = $request->getParsedBody();
            $produtoId = $args['id'];

            $produto = $entityManager->getRepository('App\Entity\Produto')->find($produtoId);
            
            if (!$produto){
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
