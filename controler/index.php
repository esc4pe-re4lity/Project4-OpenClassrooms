<?php
require('Controler.php');
try{
    if(isset($_GET['action'])){
        if($_GET['action'] == 'getAllPosts'){
            
        }
    }else{
        $posts = Controler::getAllPosts();
        require('../view/allPosts.php');
    }
}
catch(Exception $e){
    echo '<p class="error">Erreur : '.$e->getMessage().'</p>';
}