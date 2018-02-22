<?php
class User
{
    protected   $pseudo,
                $password,
                $email,
                $creationDate,
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
    public function getCreationDate(){
        return $this->creationDate;
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
    public function setCreationDate($creationDate){
        // A FAIRE - mettre la date au bon format
        $this->creationDate = $creationDate;
    }
    public function setAdmin($admin){
        $int = (int)$admin;
        if(is_int($int)){
            $this->admin = $int;
        }
    }
}