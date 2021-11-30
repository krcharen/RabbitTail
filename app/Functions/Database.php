<?php

namespace App\Functions;

use App\Exceptions\Exception;

class Database extends Connect
{

    /**
     * Database constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return mixed
     */
    public function version()
    {
        return $this->db->getAttribute(\PDO::ATTR_SERVER_VERSION);
    }

    /**
     * @param string $key
     * @return mixed|string
     */
    public function readConfig(string $key)
    {
        return $this->config[$key] ?? '';
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function rawCreate(string $sql)
    {
        return $this->db->exec($sql);
    }

    public function rawDrop(string $table = '')
    {
        $sql = "DROP TABLE {$table};";

        return $this->db->exec($sql);
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function rawSelect(string $sql)
    {
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function rawUpdate(string $sql)
    {
        return $this->db->exec($sql);
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function rawInsert(string $sql)
    {
        return $this->db->exec($sql);
    }

    /**
     * @param string $sql
     * @param array $parameters
     * @return mixed
     */
    public function preExecute(string $sql, array $parameters)
    {
        return $this->db->prepare($sql)->execute($parameters);
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function rawDelete(string $sql)
    {
        return $this->db->exec($sql);
    }
}