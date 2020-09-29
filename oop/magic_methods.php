<?php

class MagicClass
{
    private $func;
    private $data = [];

    public function __construct(callable $func)
    {
        $this->func = $func;
    }

    public function __invoke($x)
    {
        $func = $this->func;

        return $func($x);
    }

    public function __get($key)
    {
        return $this->data[$key] ?? 'not found';
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __call($name, $arguments)
    {
        echo "<br>"."Chiamata metodo '$name' ".implode(', ', $arguments)."\n";
    }
}

$func = function ($x) {
    return $x * $x * $x;
};

$magicClass = new MagicClass($func);

$magicClass->aaa    = 'bbb';
$magicClass->ccc    = 'ddd';
$magicClass->marino = 'ciao';
echo $magicClass->aaa;
echo $magicClass->ccc;

echo $magicClass->pippo;
echo $magicClass(12);

var_dump($magicClass);

$magicClass->faiQualcosa('a', 'b', 'c');
