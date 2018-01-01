<?php
class Controler
{
    public static function getAllPosts(){
        require('../model/PostManager.php');
        $posts = PostManager::getAllPosts();
        return $posts;
    }
    public static function getPost(){
        require('../model/postManager.php');
        $post = PostManager::getPost();
        return $post;
    }
    public static function getComments(){
        require('../model/commentManager.php');
        $comments = CommentManager::getComments();
        return $comments;
    }
}