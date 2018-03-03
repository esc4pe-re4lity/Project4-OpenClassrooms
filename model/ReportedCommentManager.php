<?php
class ReportedCommentManager extends Manager
{
    public function getReportedComments(){
        $reportedComments = [];
        $q=$this->db->query('SELECT * FROM comments WHERE reported=true');
        while($data=$q->fetch(PDO::FETCH_ASSOC)){
            $reportedComments[] = new Comment($data);
        }
        return $reportedComments;
    }
    public function reportComment($idComment, $idPost){
        $user = $_SESSION['user'];
        $req=$this->db->prepare('INSERT INTO reportedComments(idComment, idPost, pseudo, creationDate) VALUES(:idComment, :idPost, :pseudo, NOW())');
        $req->execute(array('idComment'=>$idComment,'idPost'=>$idPost,'pseudo'=>$user->getPseudo()));
        $req->closeCursor();
        $q=$this->db->query('UPDATE comments SET reported=true WHERE id='.$idComment);
    }
    public function deleteReportedComment($idComment){
        $q=$this->db->query('DELETE FROM reportedComments WHERE idComment='.$idComment);
    }
}