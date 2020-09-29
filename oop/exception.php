<?php

function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    return 1/$x;
}

function main(){
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
    echo inverse(7) . "\n";
// Continue execution
echo "Hello World\n";
}

try {
   main();
   echo "Hello World\n";
} catch (Exception $e) {
    var_dump($e);
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "everything continues working";

