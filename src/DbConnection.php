<?php
namespace App;
use PDO;
use PDOException;

use Dotenv\Dotenv;                        //импорт класса Dotenv из пространства имен dotenv
require_once 'dbconnect.php';
class DbConnection
{
    private static $connection;
    public static function getConnection(): PDO
    {

        if (file_exists(__DIR__."/.env"))
        {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load(); //все параметры окружения помещаются в массив $_ENV
            // var_dump($_ENV);
        }

        try {
            if (!self::$connection) self::$connection = new PDO("mysql:host=$_ENV[dbhost];dbname=$_ENV[dbname];charset=utf8mb4", $_ENV['dbuser'], $_ENV['dbpassword']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Подключение к БД выполнено";
            return (self::$connection);
        }
        catch(PDOException $e) {
            echo "Ошибка подключения к БД: " . $e->getMessage(), $e->getCode( );
            die();
        }
    }
}