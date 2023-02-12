<?php

namespace App\Entity;

use Doctrine\ORM\PersistentCollection;
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

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False, options: ['default' => 0])]
    private float $valor_total = 0;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False, options: ['default' => 0])]
    private float $troco = 0;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: False)]
    private float $desconto = 0;

    /**
     * tipo de pagamento
     * 1 => dinheiro
     * 2 => cartão de débito
     * 3 => cartão de crédito
     * 4 => pix
     */
    #[ORM\Column(type: 'integer', precision: 1, nullable: True)]
    private float $tipo_pagamento;

    #[ORM\Column(type: 'integer', precision: 1, nullable: False, options: ['default' => 1])]
    private int $status = 1;

    #[ORM\OneToMany(targetEntity: VendaProduto::class, mappedBy: 'venda')]
    private PersistentCollection $produtos;


    public function getId()
    {
        return $this->id;
    }

    public function addValorTotal($valor)
    {
        $this->valor_total += $valor;
    }

}
