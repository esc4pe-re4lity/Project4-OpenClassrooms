<?php
class PostManager extends Manager
{
    public function countPosts(){
        $q=$this->db->query('SELECT id FROM posts');
        return $q->rowCount();
    }
    public function addPost(Post $post){
        $req=$this->db->prepare('INSERT INTO posts(title, content, excerpt, creationDate) VALUES(:title, :content, :excerpt, NOW())');
        $req->execute(array('title'=>$post->getTitle(),'content'=>$post->getContent(), 'excerpt'=>$post->getExcerpt()));
        $post->hydrate([
          'id' => $this->db->lastInsertId(),
          'creationDate' => date("Y-m-d H:i:s"),
          'updated' => false
        ]);
        return $post;
    }
    public function idPostExists($idPost){
        $q=$this->db->query('SELECT id FROM posts WHERE id='.$idPost);
        if($q->rowCount() === 0){
            return false;
        }else{
            return true;
        }
    }
    public function getPost($idPost){
        $q=$this->db->query('SELECT * FROM posts WHERE id='.$idPost);
        while($data=$q->fetch(PDO::FETCH_ASSOC)){
            $post = new Post($data);
        }
        return $post;
    }
    public function getAllPosts(Paging $paging){
        $posts = [];
        $req=$this->db->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT :offset, :limit');
        $req->bindValue(':offset', $paging->getOffset(), PDO::PARAM_INT);
        $req->bindValue(':limit', $paging->getLimit(), PDO::PARAM_INT);
        $req->execute();
        while($data=$req->fetch(PDO::FETCH_ASSOC)){
            $posts[] = new Post($data);
        }
        return $posts;
    }
    public function updatePost(Post $post){
        $req=$this->db->prepare('UPDATE posts SET title=:title, content=:content, excerpt=:excerpt, updated=true, updatedDate=NOW() WHERE id='.$post->getId());
        $req->execute(array('title'=>$post->getTitle(),'content'=>$post->getContent(),'excerpt'=>$post->getExcerpt()));
        $post->hydrate([
          'updatedDate' => date("Y-m-d H:i:s"),
          'updated' => true
        ]);
        return $post;
    }
    public function deletePost($idPost){
        $q=$this->db->query('DELETE FROM posts WHERE id='.$idPost);
        $q->closeCursor();
        $q=$this->db->query('DELETE FROM comments WHERE idPost='.$idPost);
        $q->closeCursor();
        $q=$this->db->query('DELETE FROM reportedComments WHERE idPost='.$idPost);
    }
}