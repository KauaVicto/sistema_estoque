<?php

namespace App\Model;

use DateTime;

class Token extends Connection
{

    public static function saveToken(array $data, \App\Entity\Usuario $usuario)
    {
        $entityManager = self::connect();

        //$objUsuario = Usuario::findUsuario($data['usuario']);

        $objDate = new DateTime($data['expired_at']);

        $objToken = new \App\Entity\Token();
        $objToken->setToken($data['token']);
        $objToken->setRefreshToken($data['refresh_token']);
        $objToken->setExpiredAt($objDate);
        $objToken->setUsuario($usuario);

        $entityManager->persist($objToken);
        $entityManager->flush();
    }
}
