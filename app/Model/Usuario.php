<?php

namespace App\Model;


class Usuario extends Connection
{

    public static function findUsuario(int $id)
    {
        $entityManager = self::connect();

        $usuario = $entityManager->find('App\Entity\Usuario', $id);

        return $usuario;
    }
}
