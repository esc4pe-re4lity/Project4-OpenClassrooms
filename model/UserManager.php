<?php
class UserManager extends DBFactory
{
   public static function addUser (User $user){
        $db = parent::loadDB();
        $req=$db->prepare('INSERT INTO users(pseudo, password, email, creationDate) VALUES(:pseudo, :password, :email, NOW())');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'->getPassword(),'email'=>$user->getEmail()));
    }
    public static function login(User $user){
        // on crée une instance de User pour crypter le password et pour vérifier les infos rentrées par l'user
        $db = parent::loadDB();
        $req=$db->prepare('SELECT id, pseudo, password, email, groupe FROM users WHERE pseudo=:pseudo AND password=:password');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'=>$user->getPassword()));
        return $req;
    }
    public static function getUser($data){
        $db = parent::loadDB();
        if(is_int($data)){
            $q=$db->query('SELECT id, pseudo, email, creationDate, groupe FROM users WHERE id='.$data);
        }else{
            $q=$db->query('SELECT id, pseudo, email, creationDate, groupe FROM users WHERE pseudo=:pseudo');
            $q->execute([':pseudo'=>$data]);
        }
        return $q;
    }
    public static function getUsers(){
        $db = parent::loadDB();
        $q=$db->query('SELECT id, pseudo, email, creationDate, groupe FROM users ORDER BY pseudo');
        $q->execute();
        return $q;
    }
    public static function updateUser(User $user){
        $db = parent::loadDB();
        $req=$db->prepare('UPDATE users SET pseudo=:pseudo, password=:password, email=:email');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'=>$user->getPassword(),'email'=>$user->getEmail()));
    }
    public static function deleteUser(){
        $db = parent::loadDB();
        $q=$db->query('DELETE FROM users WHERE id='.$_GET['id']);
    }
}