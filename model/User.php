<?php
class User
{
    protected   $pseudo,
                $password,
                $email,
                $creationDate,
                $groupe;
    
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
    public function getGroupe(){
        return $this->groupe;
    }
    public static function setPseudo($pseudo){
        if(is_int($pseudo)){
            $this->pseudo = $pseudo;
        }
    }
    public static function setPassword($password){
        // A FAIRE - ajouter un salt aléatoirement et le stocker dans le db
        $salt=hash('sha256',$this->pseudo);
        $this->password=crypt($this->password,$salt);
    }
    public static function setEmail($email){
        if(is_string($email)){
            $this->email = $email;
        }
    }
    public static function setCreationDate($creationDate){
        // A FAIRE - mettre la date au bon format
        $this->creationDate = $creationDate;
    }
    public static function setGroupe($groupe){
        // A VOIR - COMMENT JE FAIS POUR LES DIFFERENTS ROLES
        if(is_bool($groupe)){
            $this->groupe = $groupe;
        }
    }
}