<?php
class Post
{
    protected   $title,
                $content,
                $excerpt,
                $creationDate,
                $updated,
                $updatedDate;
    
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
    public function setExcerpt(){
        if(strlen($this->content)>255){
            $content = substr($this->content,0,255);
            $space = strrpos($content," ");
            $this->excerpt = substr($content,0,$space);
        }else{
            $this->excerpt = $this->content;
        }
    }
    public function setCreationDate($creationDate){
        $formatter = new IntlDateFormatter('fr_FR',
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::SHORT,
                        'Europe/Paris',
                        IntlDateFormatter::GREGORIAN);
        $date = new DateTime($creationDate);
        $this->creationDate = $formatter->format($date);
    }
    public function setUpdated($updated){
        if(is_bool($updated)){
            $this->updated = $updated;
        }
    }
    public function setUpdatedDate($updatedDate){
        // mettre la date au bon format
        $this->updatedDate = $updatedDate;
    }
}