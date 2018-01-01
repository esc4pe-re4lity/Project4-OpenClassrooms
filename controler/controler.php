<?php
class Controler
{
    public static function getAllPosts(){
        require('../model/PostManager.php');
        $posts = PostManager::getAllPosts();
        return $posts;
    }
}