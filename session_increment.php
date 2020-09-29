<?php
session_start();

if(!isset($_SESSION['incr'])){
    $_SESSION['incr'] = 0;
}else{
    $_SESSION['incr']++;
}
var_dump($_COOKIE);
var_dump($_SESSION);
echo $_SESSION['incr'];
