<?php
class ReportedComment
{
    protected   $idComment,
                $pseudo,
                $creationDate;
    
    public function getIdComment(){
        return $this->idComment;
    }
    public function getPseudo(){
        return $this->pseudo;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
    public function setIdPost($idComment){
        if(is_int($idComment)){
            $this->idComment = $idComment;
        }
    }
    public function setPseudo($pseudo){
        if(is_string($pseudo)){
            $this->pseudo = $pseudo;
        }
    }
    public function setCreationDate($creationDate){
        // mettre la date au bon format
        $this->creationDate = $creationDate;
    }
}