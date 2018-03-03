<?php
class DBFactory
{
    public static function loadDB(){
        try{
            $dbConfiguration = require('config.php');
            $db = new PDO('mysql:host='.$dbConfiguration['db_host'].';dbname='.$dbConfiguration['db_name'],$dbConfiguration['db_user'],$dbConfiguration['db_password']);
        }catch(Exception $e){
            die('Error : '.$e->getMessage());
        }
        return $db;
    }
}