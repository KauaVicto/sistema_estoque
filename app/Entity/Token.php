<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Bissolli\ValidadorCpfCnpj\CPF;

#[ORM\Entity]
#[ORM\Table(name: 'acesso.tbtokens')]
class Token
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName: "id", initialValue: 250000)]
    private int|null $id = null;

    #[ORM\Column(type: 'string', length: 1000, nullable: False)]
    private string $token;

    #[ORM\Column(type: 'string', length: 1000, nullable: False)]
    private string $refresh_token;

    #[ORM\Column(type: 'datetime', nullable: False)]
    private string $expired_at;

    #[ORM\ManyToOne(targetEntity: Pessoa::class, inversedBy: 'setPessoa')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private Pessoa $pessoa;

    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
        $pessoa->tokenPessoa($this);
    }
}

