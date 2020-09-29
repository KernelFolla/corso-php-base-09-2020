<?php


class User{
    private $salt = 'salt';
    public $username;
    private $password;

    public function __construct($username, $password){
        $this->salt = rand(1,100);
        $this->username = $username;
        $this->password = sha1($password.$this->salt);
    }

    public function checkPassword($password){
        return $this->password == sha1($password.$this->salt);
    }
}

$user = new User('marino', 'testpassword');
echo "username: $user->username \r\n";
echo $user->checkPassword('testpassword') ? 'ok' : 'ko';
var_dump($user);

