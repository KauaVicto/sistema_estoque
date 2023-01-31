<?php

namespace App\Autentication;

use \Firebase\JWT\JWT;

class AuthJwt
{


    /**
     * Função responsável por gerar um token
     * @param integer $userId
     * 
     * @return string
     */
    public static function generateToken($userId)
    {
        $key = $_ENV['SECRET_KEY'];

        $payload = [
            'iss' => 'http://sistemaestoque.com.br',
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ];
        return JWT::encode($payload, $key);
    }

    /**
     * Função responsável por validar o token
     * @param string $token
     * 
     * @return boolean
     */
    public static function validateToken($token)
    {
        $key = $_ENV['SECRET_KEY'];

        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
