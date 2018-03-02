<?php
class User
{
    protected   $pseudo,
                $password,
                $email,
                $creationDate,
                $isAdmin;
    
    public function __construct(array $data) {
        $this->hydrate($data);
    }
    public function hydrate(array $data){
        foreach ($data as $key => $value){
          $method = 'set'.ucfirst($key);
          if (method_exists($this, $method)){
            $this->$method($value);
          }
        }
    }
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
    public function getIsAdmin(){
        return $this->isAdmin;
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
        $formatter = new    IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                            IntlDateFormatter::SHORT,
                            'Europe/Paris',
                            IntlDateFormatter::GREGORIAN);
        $formattedDate = new DateTime($creationDate);
        $this->creationDate = $formatter->format($formattedDate);
    }
    public function setIsAdmin($isAdmin){
        $this->isAdmin = (int)$isAdmin;
    }
}