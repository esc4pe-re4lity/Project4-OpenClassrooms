<?php
require_once('DBFactory.php');
class CommentManager
{
    public function addComment(Comment $comment){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO comments(idPost, author, content, creationDate) VALUES(:idPost, :author, :content, NOW())');
        $req->execute(array('idPost'=>$comment->getIdPost(),'author'=>$comment->getAuthor(),'content'=>$comment->getContent()));
    }
    public function getComment(){           // PAS NECESSAIRE - A VOIR
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE id='.$_GET['id']);
        return $q;
    }
    public function getComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE idPost='.$_GET['id'].' ORDER BY id DESC');
        return $q;
    }
    public function getAllComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments ORDER BY id DESC');
        return $q;
    }
    public function updateComment(){
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE comments SET author=:author, content=:content WHERE id='.$_GET['id']);
        $req->execute(array('author'=>$_POST['author'],'content'=>$_POST['content']));
    }
    public function deleteComment(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM comments WHERE id='.$_GET['id']);
    }
}