<?php

class FrontController
{
    private $logsRepository;
    private $controller;

    public function __construct(UserLogsRepository $logsRepository, AuthController $controller)
    {
        $this->logsRepository = $logsRepository;
        $this->controller     = $controller;
    }


    public function execute()
    {
        /*
         * qui inizia l'esecuzione principale di pagina
         */
        $isLogged = $this->controller->isLogged();

        /*
         * se action è login significa che sto facendo login
         * eseguo quindi le relative funzioni per il login
         */
        if (isset($_POST['action']) && $_POST['action'] == 'login') {
            $isLogged = $this->controller->doLogin($_POST["username"], $_POST["password"]);
            if ($isLogged) {
                $this->logsRepository->trackAction($_POST['username'], 'login');
            }
        } elseif (isset($_GET["action"]) && $_GET["action"] == 'logout') {

            $this->controller->doLogout();
            echo "Logout eseguito con successo";
            $isLogged = false;
            /*
             * faccio redirect alla stessa pagina senza la querystring,
             * così da evitare altri problemi se refresho la pagina
             */
            header('Location: '.$_SERVER['PHP_SELF']);
            exit();
        }

        /**
         * se non sono loggato renderizzo il form di login altrimenti
         * mostro cio' che puo' fare chi è loggato
         */
        if ( ! $isLogged) {
            include 'views/login_form.php';
        } else {
            if (isset($_GET["delete_log"])) {
                $this->logsRepository->deleteAction($_GET['delete_log']);
                echo "action {$_GET['delete_log']} cancellata con successo";
            }
            if (isset($_POST["action"]) && $_POST['action'] == 'change_password') {
                $this->controller->doChangePassword();
            }

            $this->logsRepository->trackAction(
                $this->controller->getCurrentUsername(),
                'pageview'
            );
            $results = $this->logsRepository->getActions();
            include 'views/last_actions.php';
            include 'views/change_password.php';
            include 'views/logout_button.php';
        }
    }
}
