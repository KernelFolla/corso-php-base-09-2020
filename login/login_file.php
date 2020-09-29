<?php
/*
 * a differenza di login questo script mantiene le credenziali in un file (users.txt)
 * inoltre logga le azioni in un file loggedusers.txt
 */

function loadUsers()
{
    $data  = file_get_contents('users.txt');
    $data  = explode("\r\n", $data);
    $users = [];
    foreach ($data as $row) {
        $tmp = explode('|', $row);
        if (count($tmp) == 2) {
            $users[$tmp[0]] = $tmp[1];
        }
    }

    return $users;
}

function doLogin($username, $password)
{
    $users = loadUsers();
    if ( ! isset($users[$username])) {
        echo "Username non valido.";
        $res = false;
    } else if ($password != $users[$username]) {
        echo "Password non valida.";
        $res = false;
    } else {
        echo "Benvenuto!!!";
        $_SESSION["username"] = $username;
        $res                  = true;
    }

    return $res;
}

function trackLogin($username)
{
    $file = fopen('loggedusers.txt', 'a');
    $date = date('Y-m-d H:i:s');
    fwrite($file, "in data $date $username ha fatto login \r\n");
}

function trackLogout($username)
{
    $file = fopen('loggedusers.txt', 'a');
    $date = date('Y-m-d H:i:s');
    fwrite($file, "in data $date $username ha fatto Logout \r\n");
}

session_start();
$isLogged = isset($_SESSION["username"]);
/*$users =[
  "marino" => 4,
  "michele" => 7,
  "ivan" => 9];*/

$sent = ! empty($_GET["username"]);
if ($sent) {
    $isLogged = doLogin($_GET["username"], $_GET["password"]);
    if ($isLogged) {
        trackLogin($_GET['username']);
    }
}
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    $_SESSION["username"] = null;
    trackLogout($_SESSION["username"]);
    $isLogged = false;

}
if ( ! $isLogged) {
    ?>

    <form>
        <fieldset>
            <legend>Area Riservata</legend>
            <br>
            <label>Nome
            <input type="text" name="username"><br></label>
            <label>Password
            <input type="password" name="password"><br></label>
            <button type="submit">Invia</button>
        </fieldset>
    </form>

    <?php

} else {
    echo nl2br(file_get_contents('loggedusers.txt'));
    ?>
    <br>
    <a href="?logout=1">LogOut</a>
    <?php
}
