<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rooter
 *
 * @author Fiamma
 */

require('Controler.php');
function chargerClasse($classe){
    require('model/'.$classe.'.php');
}
spl_autoload_register('chargerClasse');
session_start();

class Rooter {
    private static $instance;
    protected $user;
    
    public function setUser($user){
        if(is_object($user)){
            $this->user = $user;
        }
    }
    public function getUser(){
        return $this->user;
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }
    private function __construct(){
        $this->initURL();
    }
    
    protected function ifAdmin($fileName){
        if(isset($_SESSION['user'])){
            $this->setUser($_SESSION['user']);
            if($this->getUser()->getAdmin() === 1){
                $url = 'view/admin/'.$fileName.'.php';
                return $url;
            }else{
                $url = 'view/user/'.$fileName.'.php';
                return $url;
            }
        }else{
            $url = 'view/'.$fileName.'.php';
            return $url;
        }
    }
    protected function allPosts(){
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            $paging = Controler::paging($page);
            if(!empty($page)){
                if($page <= $paging->getNumberOfPages()){
                    $posts = Controler::getAllPosts($paging);
                    $url = $this->ifAdmin('allPosts');
                    $user = $this->getUser();
                    require($url);
                }else{
                    throw new Exception('Le numéro de la page n\'existe pas');
                }
            }else{
                throw new Exception('Le numéro de la page doit être déterminé');
            }
        }else{
            $paging = Controler::paging(1);
            $posts = Controler::getAllPosts($paging);
            $url = $this->ifAdmin('allPosts');
            $user = $this->getUser();
            require($url);
        }
    }
    protected function post(){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
            if(!empty($id)){
                $post = Controler::getPost();
                if($post->rowCount() == 0){
                    throw new Exception('Ce post n\'existe pas');
                }else{
                    $comments = Controler::getComments();
                    $url = $this->ifAdmin('post');
                    $user = $this->getUser();
                    require($url);
                }
            }else{
                throw new Exception('Aucun identifiant de post a été sélectionné');
            }
        }else{
            throw new Exception('L\'identifiant du post doit être déterminé');
        }
    }
    protected function addPost(){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            if($user->getAdmin() == 1){
                if(isset($_POST['title'])&&isset($_POST['content'])){
                    if(!empty(trim($_POST['title']))&&!empty(trim($_POST['content']))){
                        $postId = Controler::addPost();
                        $action = 'addPost';
                        header('Location: index.php?action=post&id='.$postId);
                    }else{
                        throw new Exception('Formulaire incomplet ou vide');
                    }
                }else{
                    require('view/admin/addPost.php');
                }
            }else{
                throw new Exception('Vous devez être Admin pour accéder au contenu de cette page');
            }
        }else{
            throw new Exception('Vous devez vous identifier pour pouvoir accéder au contenu de cette page');
        }
    }
    protected function updatePost(){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
            if(!empty($id)){
                $result = Controler::idPostExists();
                if($result->rowCount() == 0){
                    throw new Exception('Ce post n\'existe pas');
                }else{
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        if($user->getAdmin() == 1){
                            if(isset($_POST['title'])&&isset($_POST['content'])){
                                if(!empty(trim($_POST['title']))&&!empty(trim($_POST['content']))){
                                    Controler::updatePost();
                                    $action = 'updatePost';
                                    header('Location: index.php?action=post&id='.$id);
                                }else{
                                    throw new Exception('Formulaire incomplet ou vide');
                                }
                            }else{
                                $post = Controler::getPost();
                                require('view/admin/updatePost.php');
                            }
                        }else{
                            throw new Exception('Vous devez être Admin pour accéder au contenu de cette page');
                        }
                    }else{
                        throw new Exception('Vous devez vous identifier pour pouvoir accéder au contenu de cette page');
                    }
                }
            }else{
                throw new Exception('Aucun identifiant de post a été sélectionné');
            }
        }else{
            throw new Exception('L\'identifiant du post doit être déterminé');
        }
    }
    protected function deletePost(){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
            if(!empty($id)){
                $result = Controler::idPostExists();
                if($result->rowCount() == 0){
                    throw new Exception('Ce post n\'existe pas');
                }else{
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        if($user->getAdmin() == 1){
                            Controler::deletePost();
                            $action = 'deletePost';
                            header('Location: index.php');
                        }else{
                            throw new Exception('Vous devez être Admin pour accéder au contenu de cette page');
                        }
                    }else{
                        throw new Exception('Vous devez vous identifier pour pouvoir accéder au contenu de cette page');
                    }
                }
            }else{
                throw new Exception('Aucun identifiant de post a été sélectionné');
            }
        }else{
            throw new Exception('L\'identifiant du post doit être déterminé');
        }
    }
    protected function addComment(){
        if(isset($_GET['idPost'])){
            $idPost = (int)$_GET['idPost'];
            if(!empty($idPost)){
                if(isset($_POST['content'])){
                    if(!empty(trim($_POST['content']))){
                        Controler::addComment();
                        $action = 'addComment';
                        header('Location: index.php?action=post&id='.$idPost);
                    }else{
                        throw new Exception('Formulaire incomplet ou vide');
                    }
                }else{
                    throw new Exception('Les données du formulaire n\'ont pas été transmises');
                }
            }else{
                throw new Exception('Aucun identifiant de post a été sélectionné');
            }
        }else{
            throw new Exception('L\'identifiant du post doit être déterminé');
        }
    }
    protected function deleteComment(){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
            if(!empty($id)){
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    if($user->getAdmin() == 1){
                        Controler::deleteComment();
                        $action = 'deleteComment';
                        header('Location: index.php');
                    }else{
                        throw new Exception('Vous devez être Admin pour accéder au contenu de cette page');
                    }
                }else{
                    throw new Exception('Vous devez vous identifier pour pouvoir accéder au contenu de cette page');
                }
            }else{
                throw new Exception('Aucun identifiant de commentaire a été sélectionné');
            }
        }else{
            throw new Exception('L\'identifiant du commentaire doit être déterminé');
        }
    }
    protected function reportComment(){
        if(isset($_GET['id'])&&isset($_GET['idPost'])){
            $id = (int)$_GET['id'];
            $idPost = (int)$_GET['idPost'];
            if(!empty($id)&&!empty($idPost)){
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    if($user->getAdmin() == 1){
                        throw new Exception('L\'admin n\'a pas besoin de signaler les commentaires, il peut les supprimer directement');
                    }else{
                        Controler::reportComment();
                        $action = 'reportComment';
                        header('Location: index.php?action=post&id='.$idPost);
                    }
                }else{
                    throw new Exception('Vous devez vous identifier pour pouvoir signaler le commentaire');
                }
            }else{
                throw new Exception('Aucun identifiant de post a été sélectionné');
            }
        }else{
            throw new Exception('L\'identifiant du post doit être déterminé');
        }
    }
    protected function getReportedComments(){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            if($user->getAdmin() == 1){
                $comments = Controler::getReportedComments();
                if($comments->rowCount() == 0){
                    throw new Exception('Il n\'y a pas de commentaires signalés');
                }else{
                    require('view/admin/reportedComments.php');
                }
            }else{
                throw new Exception('Vous devez être Admin pour accéder au contenu de cette page');
            }
        }else{
            throw new Exception('Vous devez vous identifier pour pouvoir signaler le commentaire');
        }
    }
    protected function createAccount(){
        if(isset($_POST['pseudo'])&&isset($_POST['password'])&&isset($_POST['email'])){
            if(!empty(trim($_POST['pseudo']))&&!empty(trim($_POST['password']))&&!empty(trim($_POST['email']))){
                $result = Controler::pseudoExists();
                if($result->rowCount() == 0){
                    $user = Controler::createAccount();
                    $_SESSION['user'] = $user;
                    Controler::sendEmail();
                    $action = 'createAccount';
                    header('Location: index.php');
                }else{
                    throw new Exception('Pseudo déjà utilisé');
                }
            }else{
                throw new Exception('Formulaire incomplet ou vide');
            }
        }else{
            require('view/createAccount.php');
        }
    }
    protected function updateUser(){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            if(isset($_POST['pseudo'])&&isset($_POST['email'])){
                if(!empty(trim($_POST['pseudo']))&&!empty(trim($_POST['email']))){
                    $result = Controler::pseudoExists();
                    $row=$result->fetch();
                    if($result->rowCount() == 0 || $row['pseudo'] === $user->getPseudo()){
                        $updatedUser = Controler::updateUser();
                        $_SESSION=array();
                        $_SESSION['user'] = $updatedUser;
                        $action = 'updateUser';
                        header('Location: index.php?action=updateUser');
                    }else{
                        throw new Exception('Pseudo déjà utilisé');
                    }
                }else{
                    throw new Exception('Formulaire incomplet ou vide');
                }
            }else{
                if($user->getAdmin() == 1){
                    require('view/admin/updateUser.php');
                }else{
                    require('view/user/updateUser.php');
                }
            }
        }else{
            throw new Exception('Vous devez vous identifier pour pouvoir accéder au contenu de cette page');
        }
    }
    protected function updatePassword(){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            if(isset($_POST['password'])){
                if(!empty(trim($_POST['password']))){
                    Controler::updatePassword();
                    $action = 'updateUser';
                    header('Location: index.php?action=updateUser');
                }else{
                    throw new Exception('Formulaire incomplet ou vide');
                }
            }else{
                if($user->getAdmin() == 1){
                    require('view/admin/updateUser.php');
                }else{
                    require('view/user/updateUser.php');
                }
            }
        }else{
            throw new Exception('Vous devez vous identifier pour pouvoir accéder au contenu de cette page');
        }
    }
    protected function login(){
        if(isset($_POST['pseudo'])&&isset($_POST['password'])){
            $result = Controler::login();
            if(is_string($result)){
                throw new Exception($result);
            }else{
                $_SESSION['user'] = $result;
                $action = 'login';
                header('Location: index.php');
            }
        }else{
            require('view/login.php');
        }
    }
    protected function logout(){
        $_SESSION=array();
        session_destroy();
        $action = 'logout';
        header('Location: index.php');
    }
    protected function initURL(){
        try{
            if(isset($_GET['action'])){
                if($_GET['action'] == 'allPosts'){
                    $this->allPosts();
                }
                elseif($_GET['action'] == 'post'){
                    $this->post();
                }
                elseif($_GET['action'] == 'addPost'){
                    $this->addPost();
                }
                elseif($_GET['action'] == 'updatePost'){
                    $this->updatePost();
                }
                elseif($_GET['action'] == 'updatePassword'){
                    $this->updatePassword();
                }
                elseif($_GET['action'] == 'deletePost'){
                    $this->deletePost();
                }
                elseif($_GET['action'] == 'addComment'){
                    $this->addComment();
                }
                elseif($_GET['action'] == 'deleteComment'){
                    $this->deleteComment();
                }
                elseif($_GET['action'] == 'reportComment'){
                    $this->reportComment();
                }
                elseif($_GET['action'] == 'getReportedComments'){
                    $this->getReportedComments();
                }
                elseif($_GET['action'] == 'createAccount'){
                    $this->createAccount();
                }
                elseif($_GET['action'] == 'updateUser'){
                    $this->updateUser();
                }
                elseif($_GET['action'] == 'login'){
                    $this->login();
                }
                elseif($_GET['action'] == 'logout'){
                    $this->logout();
                }
                else{
                    throw new Exception('L\'action demandée ne correspond à aucune action répertoriée');
                }
            }else{
                $paging = Controler::paging(1);
                $posts = Controler::getAllPosts($paging);
                $url = $this->ifAdmin('allPosts');
                $user = $this->getUser();
                require($url);
            }
        }catch(Exception $e){
            $url = $this->ifAdmin('error');
            $user = $this->getUser();
            require($url);
        }
    }
}
