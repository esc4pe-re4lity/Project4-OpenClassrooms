<?php
require_once('DBFactory.php');
class CommentManager
{
    public static function addComment(Comment $comment){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO comments(idPost, author, content, creationDate) VALUES(:idPost, :author, :content, NOW())');
        $req->execute(array('idPost'=>$comment->getIdPost(),'author'=>$comment->getAuthor(),'content'=>$comment->getContent()));
    }
    public static function getComment(){           // PAS NECESSAIRE - A VOIR
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE id='.$_GET['id']);
        return $q;
    }
    public static function getComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE id_post='.$_GET['id'].' ORDER BY id DESC');
        return $q;
    }
    public static function getSignaledComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE signaled=true');
        // faire une jonction entre la table signaledComments et la table comments
        return $q;
    }
    public static function getAllComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments ORDER BY id DESC');
        return $q;
    }
    public static function updateComment(){
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE comments SET author=:author, content=:content WHERE id='.$_GET['id']);
        $req->execute(array('author'=>$_POST['author'],'content'=>$_POST['content']));
    }
    public static function deleteComment(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM comments WHERE id='.$_GET['id']);
    }
}