<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cadastro.tbpessoas')]
class Pessoa
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName:"id", initialValue:250000)]
    private int|null $id = null;
    #[ORM\Column(type: 'string', length:65, nullable:False)]
    private string $nome;
    #[ORM\Column(type: 'date', nullable:False)]
    private string $data_nasc;
    #[ORM\Column(type: 'string', length:11, nullable:False)]
    private string $cpf;

    private Acesso $acesso;
    
    
    public function acessoPessoa(Acesso $acesso)
    {
        $this->acesso = $acesso;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
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