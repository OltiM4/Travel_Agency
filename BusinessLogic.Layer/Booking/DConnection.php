<?php

class DConnection {
    private static $connection;

    public static function getConnection() {
        if (!self::$connection) {
            self::$connection = new PDO(
                'mysql:host=localhost;dbname=your_database_name',
                'username',
                'password'
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}

?>