<?php

class Database
{
    private static $connections = [];
    private static $config = null;

    private static function config()
    {
        if (self::$config === null) {
            self::$config = require __DIR__ . '/db-config.php';
        }

        return self::$config;
    }

    public static function connect($database)
    {
        $allConfig = self::config();

        if (!isset($allConfig[$database])) {
            throw new Exception("Database config not found for: " . $database);
        }

        if (isset(self::$connections[$database])) {
            return self::$connections[$database];
        }

        $config = $allConfig[$database];

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";

        self::$connections[$database] = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        return self::$connections[$database];
    }
}