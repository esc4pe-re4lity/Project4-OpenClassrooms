<?php
class Post
{
    protected   $title,
                $content,
                $creationDate,
                $updated,
                $updatedDate;
    
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function getCreationDate(){
        return $this->creationDate;
    }
    public function getupdated(){
        return $this->updated;
    }
    public function getUpdatedDate(){
        return $this->updatedDate;
    }
    public static function setTitle($title){
        if(is_string($title)){
            $this->title = $title;
        }
    }
    public static function setContent($content){
        if(is_string($content)){
            $this->content = $content;
        }
    }
    public static function setCreationDate($creationDate){
        // mettre la date au bon format
        $this->creationDate = $creationDate;
    }
    public static function setUpdated($updated){
        if(is_bool($updated)){
            $this->updated = $updated;
        }
    }
    public static function setUpdatedDate($updatedDate){
        // mettre la date au bon format
        $this->updatedDate = $updatedDate;
    }
}