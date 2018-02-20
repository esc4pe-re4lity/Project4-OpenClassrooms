<?php
require_once('DBFactory.php');
class UserManager
{
   public function addUser (User $user){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO users(pseudo, password, email, isAdmin, creationDate) VALUES(:pseudo, :password, :email, false, NOW())');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'=>$user->getPassword(),'email'=>$user->getEmail()));
    }
    public function login(User $user){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT * FROM users WHERE pseudo=:pseudo AND password=:password');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'=>$user->getPassword()));
        return $req;
    }
    public function pseudoExists(User $user){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT pseudo FROM users WHERE pseudo=:pseudo');
        $req->execute(array('pseudo'=>$user->getPseudo()));
        return $req;
    }
    public function getUser($data){
        $db = DBFactory::loadDB();
        if(is_int($data)){
            $q=$db->query('SELECT * FROM users WHERE id='.$data);
        }else{
            $req=$db->prepare('SELECT * FROM users WHERE pseudo=:pseudo');
            $req->execute([':pseudo'=>$data]);
        }
        return $q;
    }
    public function getUsers(){
        $db = DBFactory::loadDB();
        $q=$db->query('SELECT * FROM users ORDER BY pseudo');
        return $q;
    }
    public function updateUser(User $updatedUser){
        $user = $_SESSION['user'];
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE users SET pseudo=:newPseudo, email=:newEmail WHERE pseudo=:pseudo');
        $req->execute(array('newPseudo'=>$updatedUser->getPseudo(),'newEmail'=>$updatedUser->getEmail(),'pseudo'=>$user->getPseudo()));
    }
    public function updatePassword(User $updatedUser){
        $user = $_SESSION['user'];
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE users SET password=:password WHERE pseudo='.$user->getPseudo());
        $req->execute([':password'=>$updatedUser->getPassword()]);
    }
    public function deleteUser(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM users WHERE id='.$_GET['id']);
    }
}