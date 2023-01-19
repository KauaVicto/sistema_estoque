<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'produtos.tbestoques')]
class Estoque
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName:"id", initialValue:250000)]
    private int|null $id = null;
    #[ORM\Column(type: 'decimal')]
    private string $quantidade;

    #[ORM\ManyToOne(targetEntity: Produto::class, inversedBy: 'setProduto')]
    private Produto|null $produto = null;


    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
        $produto->produtoEstoque($this);
    }

    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function serialize(){
        return get_object_vars ($this);
    }

}