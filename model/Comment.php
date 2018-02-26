<?php
class Comment
{
    protected   $idPost,
                $author,
                $content,
                $creationDate,
                $reported;
    
    public function __construct() {
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
    public function getIdPost(){
        return $this->idPost;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getContent(){
        return $this->content;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
    public function getReported(){
        return $this->reported;
    }
    public function setIdPost($idPost){
        if(is_int($idPost)){
            $this->idPost = $idPost;
        }
    }
    public function setAuthor($author){
        if(is_string($author)){
            $this->author = $author;
        }
    }
    public function setContent($content){
        if(is_string($content)){
            $this->content = $content;
        }
    }
    public function setCreationDate($creationDate){
        // mettre la date au bon format
        $this->creationDate = $creationDate;
    }
    public function setReported($reported){
        if(is_bool($reported)){
            $this->reported = $reported;
        }
    }
}