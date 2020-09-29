<?php 
$items = [
    'mele' => rand(1,10),
    'pere' => rand(1,5),
    'banane' => rand(1, 10)
];

$singular = [
    'mele' => 'mela',
    'pere' => 'pera',
    'banane' => 'banana'
];

$i = 0;
$sum = 0;
$countItems = count($items);
echo "abbiamo $countItems tipi di frutta:\r\n";

foreach($items as $key => $value){
   $label = $value > 1 ? $key : $singular[$key];
   $i++;
   if($i == $countItems){
      echo "e infine ";
   }
   if($value == 1){
       echo "c'è una $label\r\n";
   } elseif($value > 2) {
       echo "ci sono $value $label, sono troppe!!!\r\n";
       $elemento = $key;
       continue;
   } else {
       echo "ci sono $value $label\r\n";
   }
   echo "tutto regolare \r\n";
   $sum += $value;
}
if($elemento){
   echo "ok intervenire ridurre le $elemento";
}
echo "\r\nquindi in tutto abbiamo ".$sum." frutti";
