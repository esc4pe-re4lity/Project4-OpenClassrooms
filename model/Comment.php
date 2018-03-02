<?php
class Comment
{
    protected   $id,
                $idPost,
                $author,
                $content,
                $creationDate,
                $reported;
    
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
    public function setId($id){
        $this->id = (int) $id;
    }
    public function setIdPost($idPost){
        $this->idPost = (int) $idPost;
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
        $formatter = new    IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                            IntlDateFormatter::SHORT,
                            'Europe/Paris',
                            IntlDateFormatter::GREGORIAN);
        $formattedDate = new DateTime($creationDate);
        $this->creationDate = $formatter->format($formattedDate);
    }
    public function setReported($reported){
        if(is_bool($reported)){
            $this->reported = $reported;
        }
    }
}