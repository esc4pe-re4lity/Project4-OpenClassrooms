<?php
class Post
{
    protected   $title,
                $content,
                $excerpt,
                $updated;
    
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function getExcerpt(){
        return $this->excerpt;
    }
    public function getUpdated(){
        return $this->updated;
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
    public function setUpdated($updated){
        if(is_bool($updated)){
            $this->updated = $updated;
        }
    }
}