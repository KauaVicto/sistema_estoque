<?php
namespace App;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cadastro.tbacessos')]
class Acesso
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string', length:65, nullable:False)]
    private string $usuario;
    #[ORM\Column(type: 'string', length:32, nullable:False)]
    private string $senha;
    
    #[ORM\ManyToOne(targetEntity: Pessoa::class, inversedBy: 'setPessoa')]
    private Pessoa|null $pessoa = null;

    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
        $pessoa->acessoPessoa($this);
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getData_Nasc()
    {
        return $this->data_nasc;
    }
    public function setData_Nasc($data_nasc)
    {
        $this->data_nasc = $data_nasc;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

}