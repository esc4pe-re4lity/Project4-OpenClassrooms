<?php
require('DBFactory.php');
class PostManager
{
    public static function addPost(Post $post){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO posts(title, content, creationDate) VALUES(:title, :content, NOW())');
        $q->execute(array('title'=>$post->getTitle(),'content'=>$post->getContent()));
    }
    public static function getPost(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT id, title, content, creationDate, updated, updatedDate FROM posts WHERE id='.$_GET['id']);
        return $q;
    }
    public static function getAllPosts(){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT id, title, content, creationDate, updated, updatedDate FROM posts ORDER BY id DESC LIMIT 0, 5');
        $req->execute();
        return $req;
    }
    public static function updatePost(){
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE posts SET title=:title, content=:content, updated=true, updated_date=NOW() WHERE id='.$_GET['id']);
        $req->execute(array('title'=>$_POST['title'],'content'=>$_POST['content']));
    }
    public static function deletePost(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM posts WHERE id='.$_GET['id']);
    }
}