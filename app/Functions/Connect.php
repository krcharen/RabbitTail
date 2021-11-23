<?php

namespace App\Functions;

use App\Exceptions\Exception;

class Connect
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @var
     */
    protected $db;

    /**
     * Connect constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->load();
        $this->connect();
    }

    /**
     * Load database file.
     */
    private function load()
    {
        $config = require __DIR__ . '/../../config/database.php';
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

            $this->db = new \PDO($dsn, $this->config['username'], $this->config['password'], [
                \PDO::ATTR_PERSISTENT => true
            ]);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}