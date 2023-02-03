<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'relacionamento.venda_produto')]
class VendaProduto
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName: "id", initialValue: 250000)]
    private int|null $id = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, options: ['default' => 1])]
    private float $quantidade = 1;

    #[ORM\ManyToOne(targetEntity: Venda::class, inversedBy: 'produtos')]
    #[ORM\JoinColumn(name: 'venda_id', referencedColumnName: 'id')]
    private Venda|null $venda;

    #[ORM\ManyToOne(targetEntity: Produto::class, inversedBy: 'vendas')]
    #[ORM\JoinColumn(name: 'produto_id', referencedColumnName: 'id')]
    private Produto|null $produto;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        if (is_numeric($quantidade)) {
            $this->quantidade = $quantidade;
        }
    }

    public function addQuantidade($newQuantidade)
    {
        if (is_numeric($newQuantidade)) {
            $this->quantidade += $newQuantidade;
        }
    }

    public function getVenda()
    {
        return $this->venda;
    }
    public function setVenda(Venda $venda)
    {
        $this->venda = $venda;
    }

    public function getProduto()
    {
        return $this->produto;
    }
    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
    }

}
