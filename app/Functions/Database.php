<?php

namespace App\Functions;

class Database extends Connect
{

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
     * @return mixed
     */
    public function rawDelete(string $sql)
    {
        return $this->db->exec($sql);
    }
}