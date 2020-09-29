<?php
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'application');
define('DB_PORT', 3307);

$db = new mysqli('127.0.0.1', DB_USER, DB_PASS, DB_NAME, DB_PORT);

function loadUsers()
{
    global $db;
    $results = $db->query("SELECT username, password FROM users");
    $users   = [];
    while ($row = $results->fetch_object()) {
        $key         = $row->username;
        $users[$key] = $row->password;
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

function trackAction($username, $action)
{
    global $db;
    $sql = sprintf("INSERT INTO users_logged (username, action) VALUES ('%s','%s')", $username, $action);
    $db->query($sql);
}

function renderLastActions()
{
    global $db;
    $results = $db->query("SELECT * FROM users_logged");
    ?>
    <table>
    <tr>
        <th>id</th>
        <th>username</th>
        <th>action</th>
        <th>created at</th>
    </tr><?php
    while ($row = $results->fetch_object()) {
        $createdAt = new DateTime($row->created_at);
        ?>
        <tr>
            <td><?php echo $row->id ?></td>
            <td><?php echo $row->username ?></td>
            <td><?php echo $row->action ?></td>
            <td><?php echo $createdAt->format('d/m/Y H:i:s') ?></td>
        </tr>
        <?php
    }

    ?></table><?php
    $today                 = new DateTime('today');
    $yesterday             = new DateTime('yesterday');
    $firstMondayOfTheMonth = new DateTime('-2 months next monday');
    $format                = 'Y-m-d';
    echo "today {$today->format($format)} <br/>yesterday {$yesterday->format($format)} <br/>fmotm {$firstMondayOfTheMonth->format($format)}";

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
        trackAction($_GET['username'], 'login');
    }
}
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    $_SESSION["username"] = null;
    trackAction($_SESSION["username"], 'logout');
    $isLogged = false;

}
if ( ! $isLogged) {
    ?>

    <form>
        <fieldset>
            <legend>Area Riservata</legend>
            <br>
            <label>Nome</label>
            <input type="text" name="username"><br>
            <label>Password</label>
            <input type="password" name="password"><br>
            <button type="submit">Invia</button>
        </fieldset>
    </form>

    <?php

} else {
    trackAction($_SESSION['username'], 'pageview');
    renderLastActions();
    ?>
    <br>
    <a href="?logout=1">LogOut</a>
    <?php
}
