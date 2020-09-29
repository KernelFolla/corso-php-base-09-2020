<?php

/*
 * trasformare soltanto l'estensione dell'email in maiuscolo e tenere tutto il resto in minuscolo
 * quindi una mail con MaRInO@teSt.Co.Uk diventa marino@test.co.uk
 */


function splitEmail($email)
{ // ivan@hotmail.co.uk => [ivan, hotmail, co.uk]
    $exploded = explode("@", $email);

    $dotPos    = strpos($exploded[1], ".");
    $domain    = substr($exploded[1], 0, $dotPos);
    $extension = substr($exploded[1], $dotPos + 1);

    return [$exploded[0], $domain, $extension];

}

function upperEmailExt($email)
{ // iVan@hoTmAil.co.uk => ivan@hotmail.CO.UK
    $tmp   = splitEmail($email);
    $part0 = strtolower($tmp[0]);
    $part1 = strtolower($tmp[1]);
    $part2 = strtoupper($tmp[2]);

    return "$part0@$part1.$part2";
}

foreach (['ivan@hotMail.it', 'iVan@HotMail.co.Uk', 'test@test.co.au'] as $email) {
    echo "<br/><strong>testing $email</strong><br/>";
    var_dump(splitEmail($email));
    var_dump(upperEmailExt($email));
}
?>
