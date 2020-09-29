<?php
namespace App\Test\Namespaces;

class Constants{
    const LIMIT_PAGINATION = 10;
    const PAGE_FOOTER = 'footer.html';
    const PAGE_HEADER = 'header.html';
}

echo Constants::LIMIT_PAGINATION;
echo "\r\n";
echo Constants::PAGE_FOOTER;
echo "\r\n";
echo Constants::PAGE_HEADER;
echo "\r\n";
echo Constants::class;
