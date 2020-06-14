<?php

class Conexao
{
    const servidor = 'localhost';
    const nomebd = 'webstore';
    const caracteres = 'utf8mb4';
    const usuario = 'root';
    const senha = '';
    public static $PDO;

    public static function getPDO()
    {
        if (empty(self::$PDO)) {
            try {
                self::$PDO = new PDO(
                    'mysql:host='.self::servidor.
                    ';dbname='.self::nomebd.
                    ';charset='.self::caracteres.'',
                    self::usuario,
                    self::senha
                );
            } catch (PDOException $erro) {
                die("<br>Falha ao Conectar, código: " . $erro->getcode());
            }
        }
        return self::$PDO;
    }
}
