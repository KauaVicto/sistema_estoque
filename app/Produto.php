<?php
namespace App;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'produtos.tbprodutos')]
class Produto
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string', length:65, nullable:False)]
    private string $nome;
    #[ORM\Column(type: 'text')]
    private string $descricao;
    #[ORM\Column(type: 'decimal', nullable:False)]
    private string $valor;
    #[ORM\Column(type: 'string', length:13, nullable:True, unique:True)]
    private string $codigo_barras;

    private array $estoques;

    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getCodigoBarras()
    {
        return $this->codigo_barras;
    }
    public function setCodigoBarras($codigo_barras)
    {
        $this->codigo_barras = $codigo_barras;
    }

    public function produtoEstoque(Estoque $estoque)
    {
        $this->estoques[] = $estoque;
    }

    public function serialize(){
        return get_object_vars ($this);
    }  


}