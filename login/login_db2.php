<?php
/**
 * questo file differisce da login_db perchè possiede anche il cancella log
 * e il cambia password
 */
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'application');
define('DB_PORT', 3307);

$db = new mysqli('127.0.0.1', DB_USER, DB_PASS, DB_NAME, DB_PORT);

/* check connection */
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

/*
 * carica da database l'elenco utenti
 */
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

/*
 * effettua il login salvando in sessione l'username
 */
function doLogin($username, $password)
{
    $users = loadUsers();
    if ( ! isset($users[$username])) {
        echo "Username non valido.";
        $res = false;
    } else if (sha1($password) != $users[$username]) {
        echo "Password non valida.";
        $res = false;
    } else {
        echo "Benvenuto!!!";
        $_SESSION["username"] = $username;
        $res                  = true;
    }

    return $res;
}

/*
 * eseguo il logout cancellando l'username dalla sessione
 */
function doLogout()
{
    $_SESSION["username"] = null;
}

/*
 * cambia la password a database prendendo i valori dalla superglobal $_POST
 */
function doChangePassword()
{
    $users           = loadUsers();
    $currentPassword = $users[$_SESSION['username']];
    if ($currentPassword != sha1($_POST["password_old"])) {
        echo "Password corrente non valida.";
        $res = false;
    } else if ($_POST["password"] != $_POST["password_confirm"]) {
        echo "Le due password non coincidono.";
        $res = false;
    } else {
        global $db;
        $sql = sprintf(
            "UPDATE users SET password = '%s' WHERE username = '%s'",
            sha1($_POST['password']),
            $_SESSION['username']
        );
        var_dump($sql);
        if ($db->query($sql)) {
            echo "Password cambiata con successo!!!";
            $res = true;
        } else {
            die('errore sql: '.$db->error);
        }
    }

    return $res;
}

/*
 * salva un nuovo record di log a database dell'azione passata
 */
function trackAction($username, $action)
{
    global $db;
    $sql = sprintf("INSERT INTO users_logged (username, action) VALUES ('%s','%s')", $username, $action);
    $db->query($sql);
}

/*
 * cancella un record di log dal database
 */
function deleteAction($id)
{
    global $db;
    $sql = sprintf('DELETE FROM users_logged WHERE id = %d ', $id);
    $db->query($sql);
}

/*
 * renderizzo il form di login
 */
function renderLoginForm()
{
    ?>
    <form method="POST">
        <fieldset>
            <legend>Area Riservata</legend>
            <br>
            <label>Nome
                <input type="text" name="username"><br></label>
            <label>Password
                <input type="password" name="password"><br></label>
            <button type="submit" name="action" value="login">Invia</button>
        </fieldset>
    </form>
    <?php
}

/*
 * renderizzo il form di cambio password
 */
function renderChangePasswordForm()
{
    ?>
    <form method="POST">
        <fieldset>
            <legend>Cambia password</legend>
            <br>
            <label>Vecchia Password
                <input type="password" name="password_old"><br></label>
            <label>Password
                <input type="password" name="password"><br></label>
            <label>Conferma Password
                <input type="password" name="password_confirm"><br></label>
            <button type="submit" name="action" value="change_password">Invia</button>
        </fieldset>
    </form>
    <?php
}

function renderLogoutButton()
{
    ?>
    <br>
    <a href="?action=logout">LogOut</a>
    <?php
}

/*
 * mostra a schermo l'elenco dei record di log prendendoli dal database
 */
function renderLastActions()
{
    global $db;
    $results = $db->query("SELECT * FROM users_logged ORDER BY id DESC LIMIT 10");
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
            <td><a href="?delete_log=<?php echo $row->id ?>">Cancella</a></td>
        </tr>
        <?php
    }

    ?></table><?php
}

/*
 * qui inizia l'esecuzione principale di pagina
 */
session_start();
$isLogged = isset($_SESSION["username"]);

/*
 * se action è login significa che sto facendo login
 * eseguo quindi le relative funzioni per il login
 */
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $isLogged = doLogin($_POST["username"], $_POST["password"]);
    if ($isLogged) {
        trackAction($_POST['username'], 'login');
    }
}

/*
 * se c'è logout nella superglobal $_GET cancello l'username dalla sessione
 */
if (isset($_GET["action"]) && $_GET["action"] == 'logout') {
    trackAction($_SESSION["username"], 'logout');
    doLogout();
    $isLogged = false;
}

/**
 * se non sono loggato renderizzo il form di login altrimenti
 * mostro cio' che puo' fare chi è loggato
 */
if ( ! $isLogged) {
    renderLoginForm();
} else {
    if (isset($_GET["delete_log"])) {
        deleteAction($_GET['delete_log']);
        echo "action {$_GET['delete_log']} cancellata con successo";
    }
    if (isset($_POST["action"]) && $_POST['action'] == 'change_password') {
        doChangePassword();
    }


    trackAction($_SESSION['username'], 'pageview');
    renderLastActions();
    renderChangePasswordForm();
    renderLogoutButton();
}
