<?php
namespace App;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cadastro.tbpessoas')]
class Pessoa
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string', length:65, nullable:False)]
    private string $nome;
    #[ORM\Column(type: 'date', nullable:False)]
    private string $data_nasc;
    #[ORM\Column(type: 'string', length:11, nullable:False)]
    private string $cpf;

    private Estoque $estoque;
    
    public function __construct($nome, $data_nasc, $cpf)
    {
        $this->nome = $nome;
        $this->data_nasc = $data_nasc;
        $this->cpf = $cpf;
    }

    public function acessoPessoa(Estoque $estoque)
    {
        $this->estoque = $estoque;
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