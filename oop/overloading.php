<?php

class Set{
    public $elements = [];

    public function __construct($elements){
      $this->elements = $elements;
    }

    public function addElement($element){
       if(!$this->hasElement($element)){
           $this->elements[] = $element;
       }
    }

    public function toArray(){
        return $this->elements;
    }

    public function hasElement($searchElement){
        foreach($this->elements as $element){
            if($element instanceof User){
                if($element->equals($searchElement)){
                    return true;
                }
            }elseif($element === $searchElement){
                return true;
            }
        }
        return false;
       // return array_search($searchElement, $this->elements) !== false;
    }
}

class User{
    public $id;
    public $username;

    public function __construct($id, $username){
        $this->id = $id;
        $this->username = $username;
    }

    public function equals($data){
       return $data instanceof User && $data->id == $this->id && $this->username == $data->username;
    }
}

function trasforma($user){
   $user->username = strtoupper($user->username);
}

$set = new Set(['a','b','c']);

$set->addElement('a');
$set->addElement('a');
$set->addElement('x');
$set->addElement(true);
$set->addElement(0);
$set->addElement(false);
$set->addElement(1);
$set->addElement('x');
$set->addElement(new User(1, 'ivan'));
$marino1 = new User(1, 'marino');
$set->addElement($marino1);
$marino2 = new User(1, 'marino');
$set->addElement($marino2);
$marino2->username = 'marino2';
var_dump($set->toArray());
