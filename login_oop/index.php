<?php
/**
 * questo file differisce da login_db perchè possiede anche il cancella log
 * e il cambia password
 */
include 'settings.php';
include 'includes/Db.php';
include 'includes/UserLogsRepository.php';
include 'includes/UsersRepository.php';
include 'includes/AuthController.php';
include 'includes/FrontController.php';

try {
    $db = new Db(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME,
        DB_PORT
    );
} catch (Exception $exception) {
    echo $exception->getMessage();
}

$logsRepository  = new UserLogsRepository($db);
$usersRepository = new UsersRepository($db);
$authController  = new AuthController($usersRepository, $logsRepository);
$frontController = new FrontController($logsRepository, $authController);

$frontController->execute();
