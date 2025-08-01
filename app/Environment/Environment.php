<?php

namespace App\Environment;

class Environment
{
    /**
     * Método responsável por carregar as variáveis de ambiente do projeto
     * @param string $dir Caminho absoluto da pasta onde encontra-se o arquivo .env
     * @return bool
     */
    public static function load(string $dir): bool
    {
        //VERIFICA SE O ARQUIVO .ENV EXISTE
        if (!file_exists($dir . '/.env')) {
            return false;
        }

        //DEFINE AS VARIÁVEIS DE AMBIENTE
        $lines = file($dir . '/.env');
        foreach ($lines as $line) {
            putenv(trim($line));
        }
        return true;
    }
}