<?php

namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;

class EstoqueController extends Controller
{

    /**
     * Método responsável por inserir um estoque no banco de dados
     */
    public function insert(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {

            $params = $request->getParsedBody();

            $produto = $entityManager->find('App\Entity\Produto', $params['produto_id']);

            $estoque = new \App\Entity\Estoque();
            $estoque->setQuantidade($params['quantidade']);
            $estoque->setValorUnidade($params['valor']);
            $estoque->setProduto($produto);
            $produto->setNewQuantidade($params['quantidade']);

            $entityManager->persist($estoque);
            $entityManager->flush();

            return self::view(['id' => $estoque->getId()], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }

    public function showAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        $estoqueRepository = $entityManager->getRepository('App\Entity\Estoque');
        $estoques = $estoqueRepository->findBy([], ['id' => 'DESC']);

        $estoqueArray = array_map(function ($e) {
            $produto = $e->getProduto();
            return [
                'id' => $e->getId(),
                'quantidade' => $e->getQuantidade(),
                'valor_unidade' => $e->getValorUnidade(),
                'produto' => [
                    'id' => $produto->getId(),
                    'nome' => $produto->getNome()
                ],
            ];
        }, $estoques);

        return self::view($estoqueArray, $response, 200);
    }

    public function findByProduct(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        $estoqueRepository = $entityManager->getRepository('App\Entity\Estoque');
        $estoques = $estoqueRepository->findBy(['produto' => $args['product_id']], ['id' => 'DESC']);

        $estoqueArray = array_map(function ($e) {
            return [
                'id' => $e->getId(),
                'quantidade' => $e->getQuantidade(),
                'valor_unidade' => $e->getValorUnidade()
            ];
        }, $estoques);

        return self::view($estoqueArray, $response, 200);
    }
}
