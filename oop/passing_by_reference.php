<?php


function transformArray($arr){
    $arr['username'] = strtoupper($arr['username']);
}

function transformUser($user){
    $copiaUser = clone $user;
    $copiaUser->username = strtoupper($copiaUser->username);
    var_dump($copiaUser);
}


class User{
    public $username;
    public $birthday;

    public function __construct($username, $birthday = null){
        $this->username = $username;
        if($birthday){
            if(!($birthday instanceof DateTime)){
                $birthday = new DateTime($birthday);
            }
        }
        $this->birthday = $birthday;
    }
}




$arr = ['username' => 'marino'];
transformArray($arr);
var_dump($arr);

$d = new DateTime('30 march 1985');
$user = new User('marino', $d);
transformUser($user);
var_dump($user);
