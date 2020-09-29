<?php
echo "compattando a e b\r\n";
$a = 'contenuto a';
$b = 'contenuto b';
var_dump(compact('a', 'b'));

echo "estraendo c e d da un array\r\n";
$arr = ['c' => 'pippo', 'd' => 'pluto'];
extract($arr);
echo "c contiene $c e d contiene $d";
