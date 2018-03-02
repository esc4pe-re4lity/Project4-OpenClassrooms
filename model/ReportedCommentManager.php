<?php
require_once('DBFactory.php');
class ReportedCommentManager
{
    public function getReportedComments(){
        $reportedComments = [];
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE reported=true');
        while($data=$q->fetch(PDO::FETCH_ASSOC)){
            $reportedComments[] = new Comment($data);
        }
        return $reportedComments;
    }
    public function reportComment($idComment, $idPost){
        $user = $_SESSION['user'];
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO reportedComments(idComment, idPost, pseudo, creationDate) VALUES(:idComment, :idPost, :pseudo, NOW())');
        $req->execute(array('idComment'=>$idComment,'idPost'=>$idPost,'pseudo'=>$user->getPseudo()));
        $req->closeCursor();
        $q=$db->query('UPDATE comments SET reported=true WHERE id='.$idComment);
    }
    public function deleteReportedComment($idComment){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM reportedComments WHERE idComment='.$idComment);
    }
}