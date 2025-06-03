<?php
require_once dirname(__FILE__) . "/../defines.php";

class DB
{
    private static ?DB $instance = null;

    private PDO $connection;

    private function __construct()
    {
        $dsn = DB['connection'] . ':host=' . DB['host'] . ';dbname=' . DB['database'];
        $this->connection = new PDO($dsn, DB['username'], DB['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}