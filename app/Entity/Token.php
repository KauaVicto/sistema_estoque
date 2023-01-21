<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

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
    private DateTime $expired_at;

<<<<<<< HEAD
    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy:'token')]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', onDelete:'CASCADE', nullable:False)]
    private Usuario $usuario;
=======
    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'tokenUsuario')]
    private Usuario|null $usuario = null;
>>>>>>> a043b4962ad991cebe57bfaa8435b117bedc90ba

    public function setUsuario(Usuario $usuario)
    {
        $usuario->tokenUsuario($this);
        $this->usuario = $usuario;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getToken()
    {
        return $this->token;
    }
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }
    public function setRefreshToken(string $refresh_token)
    {
        $this->refresh_token = $refresh_token;
    }

    public function getExpiredAt()
    {
        return $this->expired_at;
    }
    public function setExpiredAt(DateTime $expired_at)
    {
        $this->expired_at = $expired_at;
    }
}

