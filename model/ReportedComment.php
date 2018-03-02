<?php
class ReportedComment
{
    protected   $id,
                $idComment,
                $idPost,
                $pseudo,
                $creationDate;
    
    public function __construct(array $data) {
        $this->hydrate($data);
    }
    public function hydrate(array $data){
        foreach ($data as $key => $value){
          $method = 'set'.ucfirst($key);
          if (method_exists($this, $method)){
            $this->$method($value);
          }
        }
    }
    public function getId(){
        return $this->id;
    }
    public function getIdPost(){
        return $this->idPost;
    }
    public function getIdComment(){
        return $this->idComment;
    }
    public function getPseudo(){
        return $this->pseudo;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
    public function setId($id){
        $this->id = (int) $id;
    }
    public function setIdPost($idPost){
        $this->idPost = (int) $idPost;
    }
    public function setIdComment($idComment){
        $this->idComment = (int) $idComment;
    }
    public function setPseudo($pseudo){
        if(is_string($pseudo)){
            $this->pseudo = $pseudo;
        }
    }
    public function setCreationDate($creationDate){
        $formatter = new    IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                            IntlDateFormatter::SHORT,
                            'Europe/Paris',
                            IntlDateFormatter::GREGORIAN);
        $formattedDate = new DateTime($creationDate);
        $this->creationDate = $formatter->format($formattedDate);
    }
}