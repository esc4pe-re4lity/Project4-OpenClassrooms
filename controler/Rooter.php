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
            $data = $_SESSION['user'];
            $user = new User($data);
            if($user->getIsAdmin() === 1){
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
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        if($user->getIsAdmin() === 1){
                            require('view/admin/allPosts.php');
                        }else{
                            require('view/user/allPosts.php');
                        }
                    }else{
                        require('view/allPosts.php');
                    }
                }else{
                    throw new Exception('Le numéro de la page n\'existe pas');
                }
            }else{
                throw new Exception('Le numéro de la page doit être déterminé');
            }
        }else{
            $paging = Controler::paging(1);
            $posts = Controler::getAllPosts($paging);
            if(isset($_SESSION['user'])){
                $user = $_SESSION['user'];
                if($user->getIsAdmin() === 1){
                    require('view/admin/allPosts.php');
                }else{
                    require('view/user/allPosts.php');
                }
            }else{
                require('view/allPosts.php');
            }
        }
    }
    protected function post(){
        if(isset($_GET['id'])){
            $idPost = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if($idPost){
                $result = Controler::idPostExists($idPost);
                if($result === false){
                    throw new Exception('Ce post n\'existe pas');
                }else if($result === true){
                    $post = Controler::getPost($idPost);
                    $comments = Controler::getComments($idPost);
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        if($user->getIsAdmin() === 1){
                            require('view/admin/post.php');
                        }else{
                            require('view/user/post.php');
                        }
                    }else{
                        require('view/post.php');
                    }
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
            if($user->getIsAdmin() == 1){
                if(isset($_POST['title'])&&isset($_POST['content'])){
                    if(!empty(trim($_POST['title']))&&!empty(trim($_POST['content']))){
                        $data = [
                            'title' => filter_input(INPUT_POST, 'title', FILTER_DEFAULT),
                            'content' => filter_input(INPUT_POST, 'content', FILTER_DEFAULT),
                            'excerpt' => filter_input(INPUT_POST, 'content', FILTER_DEFAULT)
                        ];
                        $post = Controler::addPost($data);
                        header('Location: index.php?action=post&id='.$post->getId());
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
            $idPost = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if($idPost){
                $result = Controler::idPostExists($idPost);
                if($result == false){
                    throw new Exception('Ce post n\'existe pas');
                }else if($result === true){
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        if($user->getIsAdmin() == 1){
                            if(isset($_POST['title'])&&isset($_POST['content'])){
                                if(!empty(trim($_POST['title']))&&!empty(trim($_POST['content']))){
                                    $data = [
                                        'id' => $idPost,
                                        'title' => filter_input(INPUT_POST, 'title', FILTER_DEFAULT),
                                        'content' => filter_input(INPUT_POST, 'content', FILTER_DEFAULT),
                                        'excerpt' => filter_input(INPUT_POST, 'content', FILTER_DEFAULT)
                                    ];
                                    $post = Controler::updatePost($data);
                                    header('Location: index.php?action=post&id='.$idPost);
                                }else{
                                    throw new Exception('Formulaire incomplet ou vide');
                                }
                            }else{
                                $post = Controler::getPost($idPost);
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
            $idPost = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if($idPost){
                $result = Controler::idPostExists($idPost);
                if($result == false){
                    throw new Exception('Ce post n\'existe pas');
                }else if($result === true){
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        if($user->getIsAdmin() == 1){
                            Controler::deletePost($idPost);
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
            $idPost = filter_input(INPUT_GET, 'idPost', FILTER_VALIDATE_INT);
            if($idPost){
                if(isset($_POST['content'])){
                    if(!empty(trim($_POST['content']))){
                        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        Controler::addComment($idPost, $content);
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
            $idComment = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if($idComment){
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    if($user->getIsAdmin() === 1){
                        Controler::deleteComment($idComment);
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
            $idComment = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $idPost = filter_input(INPUT_GET, 'idPost', FILTER_VALIDATE_INT);
            if($idComment && $idPost){
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    if($user->getIsAdmin() === 1){
                        throw new Exception('L\'admin n\'a pas besoin de signaler les commentaires, il peut les supprimer directement');
                    }else{
                        Controler::reportComment($idComment, $idPost);
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
            if($user->getIsAdmin() == 1){
                $comments = Controler::getReportedComments();
                if(empty($comments)){
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
                $data = [
                    'pseudo' => filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
                ];
                $result = Controler::pseudoExists($data['pseudo']);
                if($result === false){
                    $user = Controler::createAccount($data);
                    var_dump($user);
                    $_SESSION['user'] = $user;
                    Controler::sendEmail();
                    header('Location: index.php');
                }else if($result === true){
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
                    $data = [
                        'pseudo' => filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
                    ];
                    $result = Controler::pseudoExists($data['pseudo']);
                    if($result === true || $data['pseudo'] === $user->getPseudo()){
                        $updatedUser = Controler::updateUser($data);
                        $_SESSION=array();
                        $_SESSION['user'] = $updatedUser;
                        header('Location: index.php?action=updateUser');
                    }else if($result === false){
                        throw new Exception('Pseudo déjà utilisé');
                    }
                }else{
                    throw new Exception('Formulaire incomplet ou vide');
                }
            }else{
                if($user->getIsAdmin() == 1){
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
                    $data = [
                        'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
                    ];
                    $updatedUser = Controler::updatePassword($data);
                    $_SESSION=array();
                    $_SESSION['user'] = $updatedUser;
                    header('Location: index.php?action=updateUser');
                }else{
                    throw new Exception('Formulaire incomplet ou vide');
                }
            }else{
                if($user->getIsAdmin() == 1){
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
            $data = [
                'pseudo' => filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];
            $result = Controler::login($data);
            if(is_string($result)){
                throw new Exception($result);
            }else{
                $_SESSION['user'] = $result;
                header('Location: index.php');
            }
        }else{
            require('view/login.php');
        }
    }
    protected function logout(){
        $_SESSION=array();
        session_destroy();
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
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    if($user->getIsAdmin() === 1){
                        require('view/admin/allPosts.php');
                    }else{
                        require('view/user/allPosts.php');
                    }
                }else{
                    require('view/allPosts.php');
                }
            }
        }catch(Exception $e){
            if(isset($_SESSION['user'])){
                $user = $_SESSION['user'];
                if($user->getIsAdmin() === 1){
                    require('view/admin/error.php');
                }else{
                    require('view/user/error.php');
                }
            }else{
                require('view/error.php');
            }
        }
    }
}
