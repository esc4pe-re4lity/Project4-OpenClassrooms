<?php
class Post
{
    protected   $id,
                $title,
                $content,
                $excerpt,
                $creationDate,
                $updated,
                $updatedDate;
    
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
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function getExcerpt(){
        return $this->excerpt;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
    public function getUpdated(){
        return $this->updated;
    }
    public function getUpdatedDate(){
        return $this->updatedDate;
    }
    public function setId($id){
        $this->id = (int) $id;
    }
    public function setTitle($title){
        if(is_string($title)){
            $this->title = $title;
        }
    }
    public function setContent($content){
        if(is_string($content)){
            $this->content = $content;
        }
    }
    public function setExcerpt($content){
        if(strlen($content)>255){
            $content = substr($content,0,255);
            $space = strrpos($content," ");
            $this->excerpt = substr($content,0,$space);
        }else{
            $this->excerpt = $content;
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
    public function setUpdated($updated){
        $this->updated = (bool) $updated;
    }
    public function setUpdatedDate($updatedDate){
        $formatter = new    IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                            IntlDateFormatter::SHORT,
                            'Europe/Paris',
                            IntlDateFormatter::GREGORIAN);
        $formattedDate = new DateTime($updatedDate);
        $this->updatedDate = $formatter->format($formattedDate);
    }
}