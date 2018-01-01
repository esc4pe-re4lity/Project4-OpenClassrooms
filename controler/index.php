<?php
require('Controler.php');
try{
    if(isset($_GET['action'])){
        if($_GET['action'] == 'getAllPosts'){
            $posts = Controler::getAllPosts();
            require('../view/allPosts.php');
        }
        elseif($_GET['action'] == 'post'){
            if(isset($_GET['id'])){
                $post = Controler::getPost();
                $comments = Controler::getComments();
                require('../view/post.php');
            }else{
                throw new Exception('Aucun identifiant de post a été sélectionné');
            }
        }
        else{
            throw new Exception('L\'action demandée ne correspond à aucune action répertoriée');
        }
    }else{
        $posts = Controler::getAllPosts();
        require('../view/allPosts.php');
    }
}catch(Exception $e){
    echo '<p class="error">Erreur : '.$e->getMessage().'</p>';
}