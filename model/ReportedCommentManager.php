<?php
require_once('DBFactory.php');
class ReportedCommentManager
{
    public function getReportedComments(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM comments WHERE reported=true');
        // faire une jonction entre la table signaledComments et la table comments
        return $q;
    }
    public function reportComment(){
        $user = $_SESSION['user'];
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO reportedComments(idComment, pseudo, creationDate) VALUES(:idComment, :pseudo, NOW())');
        $req->execute(array('idComment'=>$_GET['id'],'pseudo'=>$user->getPseudo()));
        $req->closeCursor();
        $q=$db->query('UPDATE comments SET reported=true WHERE id='.$_GET['id']);
    }
    public function deleteReportedComment(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM reportedComments WHERE idComment='.$_GET['id']);
    }
}