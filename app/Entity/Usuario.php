<?php
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cadastro.tbusuarios')]
class Usuario
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName:"id", initialValue:250000)]
    private int|null $id = null;

    #[ORM\Column(type: 'string', length:65, nullable:False, unique:True)]
    private string $usuario;
    #[ORM\Column(type: 'string', length:96, nullable:False)]
    private string $senha;

    #[ORM\OneToOne(targetEntity: Pessoa::class)]
    #[ORM\JoinColumn(name: 'pessoa_id', referencedColumnName: 'id')]
    private Pessoa|null $pessoa = null;


    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario(string $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }
    public function setSenha(string $senha)
    {
        $this->senha = $senha;
    }


}