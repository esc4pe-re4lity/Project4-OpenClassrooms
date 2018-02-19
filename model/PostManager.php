<?php
require_once('DBFactory.php');
class PostManager
{
    public function countPosts(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT id FROM posts');
        return $q->rowCount();
    }
    public function addPost(Post $post){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO posts(title, content, excerpt, creationDate) VALUES(:title, :content, :excerpt, NOW())');
        $req->execute(array('title'=>$post->getTitle(),'content'=>$post->getContent(), 'excerpt'=>$post->getExcerpt()));
        return $db->lastInsertId();
    }
    public function idPostExists(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT id FROM posts WHERE id='.$_GET['id']);
        return $q;
    }
    public function getPost(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM posts WHERE id='.$_GET['id']);
        return $q;
    }
    public function getAllPosts(Paging $paging){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT :offset, :limit');
        $req->bindValue(':offset', $paging->getOffset(), PDO::PARAM_INT);
        $req->bindValue(':limit', $paging->getLimit(), PDO::PARAM_INT);
        $req->execute();
        return $req;
    }
    public function updatePost(Post $post){
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE posts SET title=:title, content=:content, excerpt=:excerpt, updated=true, updatedDate=NOW() WHERE id='.$_GET['id']);
        $req->execute(array('title'=>$post->getTitle(),'content'=>$post->getContent(),'excerpt'=>$post->getExcerpt()));
    }
    public function deletePost(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM posts WHERE id='.$_GET['id']);
        $q->closeCursor();
        $q=$db->query('DELETE FROM comments WHERE idPost='.$_GET['id']);
    }
}