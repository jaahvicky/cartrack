<?php

// core/Model.class.php

// Base Model Class

class Model
{

    protected $db; //database connection object

    protected $table; //table name

    protected $fields = array(); //fields list

    public function __construct($table)
    {

        $dbconfig['host'] = $GLOBALS['config']['host'];

        $dbconfig['user'] = $GLOBALS['config']['user'];

        $dbconfig['password'] = $GLOBALS['config']['password'];

        $dbconfig['dbname'] = $GLOBALS['config']['dbname'];

        $dbconfig['port'] = $GLOBALS['config']['port'];

        $this->db = new Mysql($dbconfig);

        $this->table = $table;

    }

    public function getByColumn($column, $value)
    {
        $sql = "SELECT id FROM $this->table WHERE $column = :$column";
        return $this->db->getByColumn($sql, ["$column" => $value]);
    }

}