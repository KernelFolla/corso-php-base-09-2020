<?php
    $today                 = new DateTime('today');
    $yesterday             = new DateTime('yesterday');
    $firstMondayOfTheMonth = new DateTime('-2 months next monday');
    $format                = 'Y-m-d';
    echo "today {$today->format($format)} <br/>yesterday {$yesterday->format($format)} <br/>fmotm {$firstMondayOfTheMonth->format($format)}";
?>
