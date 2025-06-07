<?php

class Model
{

    public static PDO $dbCon;

    public static function getDb(): PDO
    {
        return self::$dbCon;
    }
    public static function setDb(PDO $pdo): void
    {
        self::$dbCon = $pdo;
    }
}