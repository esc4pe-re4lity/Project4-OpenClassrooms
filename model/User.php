<?php
class User
{
    protected   $pseudo,
                $password,
                $email,
                $admin;
    
    public function getPseudo(){
        return $this->pseudo;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getAdmin(){
        return $this->admin;
    }
    public function setPseudo($pseudo){
        if(is_string($pseudo)){
            $this->pseudo = strtolower($pseudo);
        }
    }
    public function setPassword($password){
        $this->password=hash('sha256',$password);
    }
    public function setEmail($email){
        if(is_string($email)){
            $this->email = $email;
        }
    }
    public function setAdmin($admin){
        $int = (int)$admin;
        if(is_int($int)){
            $this->admin = $int;
        }
    }
}