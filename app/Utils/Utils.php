<?php

namespace App\Utils;

class Utils
{
    /**
     * Método responsável por remover os acentos de uma string
     * @param string $texto
     * @return string
     */
    public static function removerAcentos(string $texto)
    {
        $arrayAcentos = array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/");
        $arrayLetras = explode(" ", "a A e E i I o O u U n N");

        return preg_replace($arrayAcentos, $arrayLetras, $texto);
    }
}
