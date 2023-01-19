<?php
namespace App\Entity;

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

    #[ORM\Column(type: 'string', length:65, nullable:False)]
    private string $usuario;
    #[ORM\Column(type: 'string', length:32, nullable:False)]
    private string $senha;
    
    #[ORM\OneToOne(targetEntity: Pessoa::class, inversedBy: 'setPessoa')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private Pessoa|null $pessoa = null;

    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
        $pessoa->usuarioPessoa($this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }


}