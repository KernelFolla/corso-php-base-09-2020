<?php

interface UserInterface
{
    public function getUsername();
}

class User
{
    public $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
}

class SimpleUser extends User implements UserInterface
{
}

class SuperUser extends User implements UserInterface
{
}

class FakeUser implements UserInterface
{
    public function getUsername()
    {
        return 'fakeusername';
    }
}

class UserList
{
    /** @var User[] */
    private $list;

    public function addUser(UserInterface $user)
    {
        $this->list[] = $user;
    }

    public function getUser(string $username): ?UserInterface
    {
        foreach ($this->list as $user) {
            if ($user->getUsername() == $username) {
                return $user;
            }
        }

        return null;
    }
}

$userList = new UserList();
foreach (
    [
        'marino' => SuperUser::class,
        'francesco' => SuperUser::class,
        'ivan' => SimpleUser::class,
        'michele' => FakeUser::class,
    ] as $name => $className
) {
    $userList->addUser(new $className($name));
}

$user = $userList->getUser('ivan');
var_dump($user);
$user = $userList->getUser('fakeusername');
var_dump($user);
