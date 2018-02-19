<?php
class Paging
{
    protected   $page,
                $limit,
                $offset,
                $numberOfPosts,
                $numberOfPages;
    
    public function getPage(){
        return $this->page;
    }
    public function getLimit(){
        return $this->limit;
    }
    public function getOffset(){
        return $this->offset;
    }
    public function getNumberOfPosts(){
        return $this->numberOfPosts;
    }
    public function getNumberOfPages(){
        return $this->numberOfPages;
    }
    public function setPage($page){
        if(is_int($page)){
            $this->page = $page;
        }
    }
    public function setLimit($limit){
        if(is_int($limit)){
            $this->limit = $limit;
        }
    }
    public function setOffset(){
        $this->offset = ($this->page * $this->limit) - $this->limit;
    }
    public function setNumberOfPosts($numberOfPosts){
        if(is_int($numberOfPosts)){
            $this->numberOfPosts = $numberOfPosts;
        }
    }
    public function setNumberOfPages(){
        $this->numberOfPages = ceil($this->numberOfPosts / $this->limit);
    }
}