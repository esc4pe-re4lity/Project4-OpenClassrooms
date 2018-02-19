<?php
class DBFactory
{
    public static function loadDB(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=projet4_test1','root','');
            //$db = new PDO('mysql:host=db714496514.db.1and1.com;dbname=db714496514','dbo714496514','mitS0uu-6691');
        }catch(Exception $e){
            die('Error : '.$e->getMessage());
        }
        return $db;
    }
}