<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'produtos.tbprodutos')]
class Produto
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\SequenceGenerator(sequenceName:"id", initialValue:250000)]
    private int|null $id = null;
    #[ORM\Column(type: 'string', length:65, nullable:False)]
    private string $nome;
    #[ORM\Column(type: 'text')]
    private string $descricao;
    #[ORM\Column(type: 'decimal', precision:8, scale:2 , nullable:False)]
    private float $valor;
    #[ORM\Column(type: 'string', length:13, nullable:True, unique:True)]
    private string|null $codigo_barras;

    private array $estoques;

    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }
    public function setValor(float $valor)
    {
        if (is_numeric($valor)){
            $this->valor = $valor;
        }
    }

    public function getCodigoBarras()
    {
        return $this->codigo_barras;
    }
    public function setCodigoBarras(string|null $codigo_barras)
    {
        $this->codigo_barras = $codigo_barras;
    }

    public function produtoEstoque(Estoque $estoque)
    {
        $this->estoques[] = $estoque;
    }

    public function serialize(){
        return get_object_vars ($this);
    }  


}