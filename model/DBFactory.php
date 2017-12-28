<?php
class DBFactory
{
    public static function loadDB(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=projet4','root','');
        }catch(Exception $e){
            die('Error : '.$e->getMessage());
        }
        return $db;
    }
}