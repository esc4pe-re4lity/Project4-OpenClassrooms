<?php
require_once('Comment.php');
class CommentManager extends Manager
{
    public function addComment(Comment $comment){
        $req=$this->db->prepare('INSERT INTO comments(idPost, author, content, creationDate) VALUES(:idPost, :author, :content, NOW())');
        $req->execute(array('idPost'=>$comment->getIdPost(),'author'=>$comment->getAuthor(),'content'=>$comment->getContent()));
    }
    public function getComments($idPost){
        $comments = [];
        $q=$this->db->query('SELECT * FROM comments WHERE idPost='.$idPost.' ORDER BY id DESC');
        while($data=$q->fetch(PDO::FETCH_ASSOC)){
            $comments[] = new Comment($data);
        }
        return $comments;
    }
    public function getAllComments(){
        $q=$this->db->query('SELECT * FROM comments ORDER BY id DESC');
        return $q;
    }
    public function deleteComment($idComment){
        $q=$this->db->query('DELETE FROM comments WHERE id='.$idComment);
    }
}