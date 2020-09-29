<?php
/*
 * questo è un login semplice che fa uso della sessione e mantiene le credenziali
 * degli gli utenti in un array
 */
session_start();
var_dump($_SESSION);
$isLogged = isset($_SESSION["username"]);
$users    = [
    "marino"  => 4,
    "michele" => 7,
    "ivan"    => 9,
];
$sent     = ! empty($_GET["username"]);
if ($sent) {
    if ( ! isset($users[$_GET["username"]])) {
        echo "Username non valido.";
    } else if ($_GET["password"] != $users[$_GET["username"]]) {
        echo "Password non valida.";
    } else {
        echo "Benvenuto!!!";
        $_SESSION["username"] = $_GET["username"];
        $isLogged             = true;
    }
}
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    $_SESSION["username"] = null;
    $isLogged             = false;
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

    ?>
    <br>
    <a href="?logout=1">LogOut</a>
    <?php
}
