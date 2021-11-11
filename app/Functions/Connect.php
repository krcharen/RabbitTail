<?php

namespace App\Functions;

use App\Exceptions\Exception;

class Connect
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @var
     */
    public $connect;

    /**
     * Connect constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->readConfig();
        $this->connect();
    }

    /**
     *
     */
    private function readConfig()
    {
        $config = require_once __DIR__ . '/../../config/database.php';
        $this->config = $config['mysql'];
    }

    /**
     * @throws Exception
     */
    private function connect()
    {
        try {
            $host = $this->config['host'];
            $port = $this->config['port'];
            $db = $this->config['database'];
            $charset = $this->config['charset'];
            $collation = $this->config['collation'];
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset;collation=$collation;";

            $this->connect = new \PDO($dsn, $this->config['username'], $this->config['password'], []);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function raw(string $sql)
    {
        return $this->connect->query($sql);
    }
}