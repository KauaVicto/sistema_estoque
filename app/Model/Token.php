<?php

namespace App\Model;

use DateTime;

class Token extends Connection
{

    public static function saveToken(array $data)
    {
        $entityManager = self::connect();


        $objUsuario = Usuario::findUsuario($data['usuario']);
        $objUsuario->setPessoa(null);

        $objDate = new DateTime($data['expired_at']);

        $objToken = new \App\Entity\Token();
        $objToken->setToken($data['token']);
        $objToken->setRefreshToken($data['refresh_token']);
        $objToken->setExpiredAt($objDate);
        $objToken->setUsuario($objUsuario);

        $entityManager->persist($objToken);
        $entityManager->flush();
    }
}
