<?php

class User{
    private $salt = 'salt';
    public $username;
    private $password;
    protected $role = 'user';

    public function __construct($username, $password){
        var_dump($this->role);
        $this->salt = rand(1,100);
        $this->username = $username;
        $this->password = sha1($password.$this->salt);
    }

    public function checkPassword($password){
        return $this->password == sha1($password.$this->salt);
    }

    public function sayHi($name = null){
        if($this instanceof Admin){
            $ret = "[ADMIN ALERT!!!]";
            $this->destroyAll();
        }
        if($name) $ret .= "Hi $name!";
        else $ret .= "Hi!";
        return $ret;
    }
}

abstract class AbstractAdmin extends User{
    public $area = 'staff';

    public function __construct($username, $password){
        $this->role = 'admin';
        parent::__construct($username, $password);
    }

    abstract public function destroyAll();

    public function sayHi($name = null){
        $res = parent::sayHi($name);
        return "$res small user!";
    }

}

class Admin extends AbstractAdmin{
    public function destroyAll(){
       echo "everything has been destroyed";
    }

    public function saySimpleHi(){
        return parent::sayHi();
    }

    public function sayHi($name = null){
        $res = parent::sayHi($name);
        return "$res I'm admin!";
    }
}

$user = new Admin('marino', 'testpassword');
echo "username: $user->username \r\n";
echo $user->checkPassword('testpassword') ? 'ok' : 'ko';
var_dump($user);
var_dump($user instanceof AbstractAdmin);
var_dump($user instanceof User);
//$user->destroyAll();
echo "\r\n";
echo $user->saySimpleHi('john');
