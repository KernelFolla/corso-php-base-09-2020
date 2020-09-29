<?php

// mostro gli errori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function disney($path)
{
    $englishNames = [
        'topolino' => 'mickey',
        'paperino' => 'donald',
        'pluto'    => 'pluto',
    ];


    if (isset($englishNames[$path])) {
        $name      = $englishNames[$path];
        $upperName = strtoupper($name);
        $fileName  = 'pagine/'.$name.'.php';
        require 'pagine/layout/header.php';
        echo "<h1 style=\"text-align: center\">{$upperName}</h1>";
        require $fileName;
        require 'pagine/layout/footer.php';
    } else {
        echo 'non trovato';
    }
}

if (isset($_SERVER['PATH_INFO'])) {
    $path       = $_SERVER['PATH_INFO'];
    $path       = substr($path, 1);
    $pathPieces = explode('/', $path);
    if (isset($pathPieces[0]) && $pathPieces[0] == 'disney') {
        disney($pathPieces[1]);
        exit();
    }
}
