<?php
require_once('DBFactory.php');
class UserManager
{
   public function addUser (User $user){
        $db = DBFactory::loadDB();
        $req=$db->prepare('INSERT INTO users(pseudo, password, email, isAdmin, creationDate) VALUES(:pseudo, :password, :email, false, NOW())');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'=>$user->getPassword(),'email'=>$user->getEmail()));
        $user->hydrate([
            'isAdmin' => false,
            'creationDate' => date("Y-m-d H:i:s")
        ]);
        return $user;
    }
    public function login(User $user){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT * FROM users WHERE pseudo=:pseudo AND password=:password');
        $req->execute(array('pseudo'=>$user->getPseudo(),'password'=>$user->getPassword()));
        $row=$req->fetch();
        if($row['pseudo']===$user->getPseudo() && $row['password']==$user->getPassword()){
            $user->hydrate([
                'email' => $row['email'],
                'isAdmin' => $row['isAdmin']
            ]);
            return $user;
        }else{
            return 'Le pseudo et/ou le mot de passe est incorrect';
        }
    }
    public function pseudoExists(User $user){
        $db = DBFactory::loadDB();
        $req=$db->prepare('SELECT pseudo FROM users WHERE pseudo=:pseudo');
        $req->execute(array('pseudo'=>$user->getPseudo()));
        if($req->rowCount() === 0){
            return true;
        }else{
            return false;
        }
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
        $user->hydrate([
          'pseudo' => $updatedUser->getPseudo(),
          'email' => $updatedUser->getEmail()
        ]);
        return $user;
    }
    public function updatePassword(User $updatedUser){
        $user = $_SESSION['user'];
        $db = DBFactory::loadDB();
        $req=$db->prepare('UPDATE users SET password=:password WHERE pseudo='.$user->getPseudo());
        $req->execute([':password'=>$updatedUser->getPassword()]);
        $user->hydrate([
          'password' => $updatedUser->getPassword()
        ]);
        return $user;
    }
    public function deleteUser(){
        $db = DBFactory::loadDB();
        $q=$db->query('DELETE FROM users WHERE id='.$_GET['id']);
    }
}