<?php


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Produto;
use App\Estoque;


return function (App $app) {

    $app->get('/produtos', function (ServerRequestInterface $request, ResponseInterface $response) {
        require_once __DIR__ . "/../bootstrap.php";


        $productRepository = $entityManager->getRepository('App\Produto');
        $produtos = $productRepository->findAll();

        $produtos_array = array_map(function ($e) {
            return $e->serialize();
        }, $produtos);


        $response->getBody()->write(json_encode($produtos_array));

        return $response->withStatus(200)->withHeader('content-type', 'application/json');
    });


    $app->get('/produtos/{id}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        require_once __DIR__ . "/../bootstrap.php";

        $produto = $entityManager->find('App\Produto', $args['id']);

        if (!is_null($produto)) {
            $dataJson = $produto->serialize();
        } else {
            $dataJson = [];
        }

        $response->getBody()->write(json_encode($dataJson));

        return $response->withStatus(200)->withHeader('content-type', 'application/json');
    });


    $app->post('/cadastrar_produto', function (ServerRequestInterface $request, ResponseInterface $response) {
        require_once __DIR__ . "/../bootstrap.php";


        $params = $request->getParsedBody();

        $produto = new Produto();
        $produto->setNome($params['nome']);
        $produto->setDescricao($params['descricao']);
        $produto->setValor($params['valor']);
        $produto->setCodigoBarras($params['codigo_barras']);

        $entityManager->persist($produto);
        $entityManager->flush();


        $response->getBody()->write(json_encode(['id' => $produto->getId()]));

        return $response->withStatus(200)->withHeader('content-type', 'application/json');
    });


    $app->post('/cadastrar_estoque', function (ServerRequestInterface $request, ResponseInterface $response) {
        require_once __DIR__ . "/../bootstrap.php";


        $params = $request->getParsedBody();

        $produto = $entityManager->find('App\Produto', $params['produto_id']);
        
        $estoque = new Estoque();
        $estoque->setProduto($produto);
        $estoque->setQuantidade($params['quantidade']);

        $entityManager->persist($estoque);
        $entityManager->flush();


        $response->getBody()->write(json_encode(['id' => $estoque->getId()]));

        return $response->withStatus(200)->withHeader('content-type', 'application/json');
    });
};
