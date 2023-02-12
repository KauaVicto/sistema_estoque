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
    #[ORM\SequenceGenerator(sequenceName: "id", initialValue: 250000)]
    private int|null $id = null;
    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private string $quantidade;
    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False)]
    private string $valor_unidade;
    
    #[ORM\ManyToOne(targetEntity: Produto::class, inversedBy: 'setProduto')]
    #[ORM\JoinColumn(nullable: False)]
    private Produto|null $produto;


    public function getProduto(): Produto
    {
        return $this->produto;
    }
    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
        $produto->produtoEstoque($this);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getQuantidade(): float
    {
        return $this->quantidade;
    }
    public function setQuantidade(float $quantidade)
    {
        if ($quantidade >= 0) {
            $this->quantidade = $quantidade;
        }
    }

    public function getValorUnidade(): float
    {
        return $this->valor_unidade;
    }

    public function setValorUnidade(float $valor_unidade)
    {
        if ($valor_unidade >= 0) {
            $this->valor_unidade = $valor_unidade;
        }
    }

    public function serialize()
    {
        return get_object_vars($this);
    }
}
