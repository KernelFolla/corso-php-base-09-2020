<?php

function splitString($a)
{
    $len = strlen($a);

    $start = substr($a, 0, $len / 2);
    $mid   = $len % 2 ? substr($a, $len / 2, 1) : null;
    $end   = substr($a, ($len / 2) + $len % 2);

    $tmp = [$start, $mid, $end];

    $ret = [];
    foreach ($tmp as $val) {
        if ($val !== null) {
            $ret[] = $val;
        }
    }

    return $ret;
}

function cleanString($str)
{
    $str = str_replace(' ', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('.', '', $str);
    $str = mb_strtolower($str);
    $str = remove_accents($str);

    return $str;
}

function isPalindrome($str)
{
    $str      = cleanString($str);
    $splitted = splitString($str);
    if (count($splitted) == 3) {
        $splitted = [$splitted[0], $splitted[2]];
    }
    $splitted[1] = strrev($splitted[1]);
    var_dump($splitted);

    return $splitted[0] == $splitted[1];
}

function remove_accents($str)
{
    return str_replace(
        ['è'],
        ['e'],
        $str
    );
}

var_dump(isPalindrome('È ressa per arraffar rare passere.'));

