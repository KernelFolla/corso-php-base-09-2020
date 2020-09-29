<?php

class AuthController
{
    private $usersRepository;
    private $logsRepository;

    public function __construct(UsersRepository $repo, UserLogsRepository $logsRepository)
    {
        session_start();
        $this->usersRepository = $repo;
        $this->logsRepository  = $logsRepository;
    }

    /*
     * effettua il login salvando in sessione l'username
     */
    public function doLogin($username, $password)
    {
        $users = $this->usersRepository->getUsers();
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
    public function doLogout()
    {
        $this->logsRepository->trackAction(
            $this->getCurrentUsername(),
            'logout'
        );
        /*
         * se c'è logout nella superglobal $_GET cancello l'username dalla sessione
         */
        $_SESSION["username"] = null;
    }

    /*
     * cambia la password a database prendendo i valori dalla superglobal $_POST
     */
    public function doChangePassword()
    {
        $users           = $this->usersRepository->getUsers();
        $currentPassword = $users[$_SESSION['username']];
        if ($currentPassword != sha1($_POST["password_old"])) {
            echo "Password corrente non valida.";
            $res = false;
        } else if ($_POST["password"] != $_POST["password_confirm"]) {
            echo "Le due password non coincidono.";
            $res = false;
        } else {
            $this->usersRepository->changePassword($_SESSION['username'], $_POST['password']);
            echo "Password cambiata con successo!!!";
            $res = true;
        }

        return $res;
    }

    public function isLogged()
    {
        return isset($_SESSION["username"]);
    }

    public function getCurrentUsername()
    {
        return $this->isLogged() ? $_SESSION["username"] : null;
    }
}
