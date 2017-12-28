<?php
class DBFactory
{
    public static function loadDB(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=projet4_test1','root','');
        }catch(Exception $e){
            die('Error : '.$e->getMessage());
        }
        return $db;
    }
}