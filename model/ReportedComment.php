<?php
class ReportedComment
{
    protected   $idComment,
                $pseudo;
    
    public function getIdComment(){
        return $this->idComment;
    }
    public function getPseudo(){
        return $this->pseudo;
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
}