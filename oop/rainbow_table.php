<?php

$table = [];
for($i = 0; $i<9999; $i++){
   $table[sha1($i)] = $i;
}

echo $table['7110eda4d09e062aa5e4a390b0a572ac0d2c0220'];
