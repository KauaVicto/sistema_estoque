<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'produtos.tbvendas')]
class Venda
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName: "id", initialValue: 250000)]
    private int|null $id = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False)]
    private float $valor_total;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False, options: ['default' => 0])]
    private float $troco = 0;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False)]
    private float $desconto;

    /**
     * tipo de pagamento
     * 1 => dinheiro
     * 2 => cartão de débito
     * 3 => cartão de crédito
     * 4 => pix
     */
    #[ORM\Column(type: 'integer', precision: 1, nullable: False)]
    private float $tipo_pagamento;

    #[ORM\Column(type: 'integer', precision: 1, nullable: False, options: ['default' => 1])]
    private bool $status;

    #[ORM\OneToMany(targetEntity: VendaProduto::class, mappedBy: 'venda')]
    private ArrayCollection $produtos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }
}
