<?php
class Comment
{
    protected   $idPost,
                $author,
                $content,
                $creationDate,
                $signaled;
    
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
    public function getSignaled(){
        return $this->signaled;
    }
    public static function setIdPost($idPost){
        if(is_int($idPost)){
            $this->idPost = $idPost;
        }
    }
    public static function setAuthor($author){
        if(is_string($author)){
            $this->author = $author;
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
    public static function setSignaled($signaled){
        if(is_bool($signaled)){
            $this->signaled = $signaled;
        }
    }
}