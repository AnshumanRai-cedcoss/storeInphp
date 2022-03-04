<?php

class user extends DB
{
    public $username;
    public $password;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct($username, $firstname, $lastname, $email, $password)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
    }
    public function addUser()
    {
        // return $this->email;
        try {
            DB::getInstance()->exec("INSERT INTO Users(username,firstname,lastname,email,password,role,status) 
                             VALUES('$this->username','$this->firstname',' $this->lastname','$this->email','$this->password','User','Pending')");
            return "Waiting to be approved";
        } catch (Exception $e) {
            return "Error : Already registered! Please sign in";
        }
    }
    public function update()
    {
    }
}
