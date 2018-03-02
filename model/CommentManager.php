<?php
require_once('DBFactory.php');
require_once('Comment.php');
class CommentManager
{
    public function addComment(Comment $comment){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO comments(idPost, author, content, creationDate) VALUES(:idPost, :author, :content, NOW())');
        $req->execute(array('idPost'=>$comment->getIdPost(),'author'=>$comment->getAuthor(),'content'=>$comment->getContent()));
    }
    public function getComments($idPost){
        $db = DBFactory::loadDB();
        $comments = [];
        $q=$db->query('SELECT * FROM comments WHERE idPost='.$idPost.' ORDER BY id DESC');
        while($data=$q->fetch(PDO::FETCH_ASSOC)){
            $comments[] = new Comment($data);
        }
        return $comments;
    }
    public function getAllComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments ORDER BY id DESC');
        return $q;
    }
    public function deleteComment($idComment){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM comments WHERE id='.$idComment);
    }
}