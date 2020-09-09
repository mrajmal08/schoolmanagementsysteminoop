<?php
require_once "../views/includes/config.php";
abstract class Database
{
    public $conn;

    function __construct()
    {

        try {
            $this->conn = new PDO("mysql:host=" . servername . ";dbname=" . db . "", username, password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    abstract protected function show($table, $single_user = false, $where = false);

    abstract protected function insert($table, $columns, $values, $data);

    abstract protected function delete($table, $where);

    abstract protected function update($table, $data, $where);
}