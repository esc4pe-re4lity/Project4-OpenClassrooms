<?php
abstract class Manager
{
    protected $db;
    
    public function __construct() {
        $this->loadDB();
    }
    public function loadDB(){
        try{
            $dbConfiguration = require 'config.php';
            $dsn = "mysql:dbname=".$dbConfiguration['db_name']."; host=".$dbConfiguration['db_host']."";
            $this->db = new \PDO($dsn, $dbConfiguration['db_user'], $dbConfiguration['db_password']);
        }catch(\PDOException $exception){
            die($exception->getTraceAsString());
        }
    }
}