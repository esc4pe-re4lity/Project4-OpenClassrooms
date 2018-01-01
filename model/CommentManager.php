<?php
require_once('DBFactory.php');
class CommentManager
{
    public static function addComment(Comment $comment){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO comments(idPost, author, content, creationDate) VALUES(:idPost, :author, :content, NOW())');
        $q->execute(array('idPost'=>$comment->getIdPost(),'author'=>$comment->getAuthor(),'content'=>$comment->getContent()));
    }
    public static function getComment(){           // PAS NECESSAIRE - A VOIR
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT id, idPost, author, content, creationDate FROM comments WHERE id='.$_GET['id']);
        return $q;
    }
    public static function getComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT id, idPost, author, content, creationDate FROM comments WHERE idPost='.$_GET['id'].'ORDER BY id DESC');
        return $q;
    }
    public static function getSignaledComments(){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT id, idPosts, author, content, creationDate FROM comments WHERE signaled=true');
        // faire une jonction entre ka table signaledComments et la table comments
        return $req;
    }
    public static function getAllComments(){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT id, idPost, author, content, creationDate FROM comments ORDER BY id DESC');
        $req->execute();
        return $req;
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