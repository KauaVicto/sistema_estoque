<?php

namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\DBAL\Exception;

class VendaController extends Controller
{

    /**
     * Método responsável por inserir um produto no banco de dados
     */
    public function insert(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {
            $venda = new \App\Entity\Venda();

            $entityManager->persist($venda);
            $entityManager->flush();

            return self::view(['id' => $venda->getId()], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }

    public function insertProduct(ServerRequestInterface $request, ResponseInterface $response)
    {
        require_once __DIR__ . "/../../bootstrap.php";

        try {
            $params = $request->getParsedBody();

            $vendaProdutoRepository = $entityManager->getRepository('App\Entity\VendaProduto');
            $existeVendaProduto = $vendaProdutoRepository->findBy(['venda' => $params['venda_id'], 'produto' => $params['produto_id']]);
            

            $produto = $entityManager->find('App\Entity\Produto', $params['produto_id']);
            $valorProduto = $produto->getValor();
            
            if (!$existeVendaProduto){
                $venda = $entityManager->find('App\Entity\Venda', $params['venda_id']);

                $venda->addValorTotal($valorProduto * $params['quantidade']);
                $produto->removeQuantidade($params['quantidade']);
                
                $vendaProduto = new \App\Entity\VendaProduto();
                $vendaProduto->setProduto($produto);
                $vendaProduto->setVenda($venda);
                $vendaProduto->setQuantidade($params['quantidade']);
                
                $entityManager->persist($vendaProduto);

            } else {

                $vendaProduto = $existeVendaProduto[0];
                
                $vendaProduto->getVenda()->addValorTotal($valorProduto * $params['quantidade']);
                $vendaProduto->getProduto()->removeQuantidade($params['quantidade']);

                $vendaProduto->addQuantidade($params['quantidade']);
                
                $entityManager->persist($vendaProduto);

            }

            $entityManager->flush();

            return self::view(['id' => $vendaProduto->getId()], $response, 201);
        } catch (Exception $e) {
            return self::view(['error' => $e->getMessage()], $response, 409);
        }
    }
}
