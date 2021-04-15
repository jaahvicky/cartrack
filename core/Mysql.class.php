<?php

class Mysql
{

    protected $conn = false; //DB connection resources

    protected $sql; //sql statement

    /**
     * Constructor, to connect to database
     * @param config string configuration array
     */

    public function __construct($config = array())
    {

        $host = isset($config['host']) ? $config['host'] : 'localhost';

        $user = isset($config['user']) ? $config['user'] : 'root';

        $password = isset($config['password']) ? $config['password'] : '';

        $dbname = isset($config['dbname']) ? $config['dbname'] : '';

        $port = isset($config['port']) ? $config['port'] : '5432';

        $dsn = "pgsql:host=$host;dbname=$dbname";
        $this->conn = new PDO($dsn, $user, $password);
    }

    /**
     * Execute SQL statement
     *
     */
    public function query($sql)
    {

        $this->sql = $sql;

        $stm = $this->conn->prepare($this->sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
    /**
     * Get a record by id
     */
    public function getById($sql, $id)
    {
        $this->sql = $sql;
        $stm = $this->conn->prepare($this->sql);
        $stm->bindValue(':id', $id);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {

            return $result[0];

        } else {

            return false;

        }

    }
    /**
     * Get a record by Column
     */
    public function getByColumn($sql, $record)
    {
        $this->sql = $sql;
        $stm = $this->conn->prepare($this->sql);
        $stm->execute($record);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {

            return $result[0];

        } else {

            return false;

        }

    }
    /**
     * remove a record
     */
    public function removeById($sql, $id)
    {
        $this->sql = $sql;
        $stm = $this->conn->prepare($this->sql);
        $stm->bindValue(':id', $id);
        $stm->execute();
        return $stm->rowCount();

    }

    /**
     * insert records
     */
    public function insert($sql, $record)
    {
        $this->sql = $sql;

        $stm = $this->conn->prepare($this->sql);

        $result = $stm->execute($record);

        return $result;

    }
    /**
     * update records
     */
    public function update($sql, $data)
    {
        $this->sql = $sql;
        $stm = $this->conn->prepare($this->sql);
        $results = $stm->execute($data);
        return $results;

    }

    /**
     * Get all records
     */
    public function getAll($sql)
    {
        return $this->query($sql);
    }

    /**
     * Get last insert id
     */
    public function getInsertId()
    {

        return $this->conn->lastInsertId();

    }

}