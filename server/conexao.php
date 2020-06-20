<?php

// Limitar o acesso.

class Conexao
{
    const servidor = 'localhost';
    const nomebd = 'grancacao';
    const caracteres = 'utf8mb4';
    const usuario = 'root';
    const senha = '';
    private static $PDO;
    public static $msg;

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
                self::$msg = "Falha ao Conectar, código: ".$erro->getcode();
                return false;
            }
        }
        return self::$PDO;
    }

    public static function PDO()
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
                self::$msg = "Falha ao Conectar, código: ".$erro->getcode();
                return false;
            }
        }
        return self::$PDO;
    }
}
