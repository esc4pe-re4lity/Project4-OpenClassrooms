<?php
class Controler
{
    public static function getAllPosts(){
        require_once('../model/PostManager.php');
        $posts = PostManager::getAllPosts();
        return $posts;
    }
    public static function getPost(){
        require_once('../model/PostManager.php');
        $post = PostManager::getPost();
        return $post;
    }
    public static function getComments(){
        require_once('../model/CommentManager.php');
        $comments = CommentManager::getComments();
        return $comments;
    }
}