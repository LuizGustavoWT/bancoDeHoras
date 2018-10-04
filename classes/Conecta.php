<?php

class Conecta
{
    public static $db;

    public static function getConexao()
    {
        if (!isset(self::$db))
        {

            self::$db = new PDO("mysql:dbname=cwazoiep_banco_sorriso;host=localhost","root","");

        }

        return self::$db;
    }
}
