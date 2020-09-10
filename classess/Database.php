<?php

abstract class Database
{
    public static $conn;
//    public static $table;
    public $table;
    public function __construct($table = null)
    {
        if(!empty($table)) {
//            self::$table = $table;
            $this->table = $table;
//            var_dump(self::$table);
        }
        try {
            $conn = new PDO("mysql:host=localhost;dbname=schoolsystem",
                "root", "");
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn = $conn;
            //echo "Connected successfully";
        } catch (PDOException $e) {
            require "Connection failed: " . $e->getMessage();
        }
    }

    abstract public function show($single_user = false, $where = false);

    abstract protected function insert($columns, $values, $data);

    abstract protected function delete($where);

    abstract protected function update($data, $where);
}
