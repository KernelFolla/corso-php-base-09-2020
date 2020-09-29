<?php

class UsersRepository
{
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /*
     * carica da database l'elenco utenti
     */
    function getUsers()
    {
        $results = $this->db->getList("SELECT username, password FROM users");

        $users = [];
        foreach ($results as $row) {
            $key         = $row->username;
            $users[$key] = $row->password;
        }

        return $users;
    }

    public function changePassword()
    {
        $sql = sprintf(
            "UPDATE users SET password = '%s' WHERE username = '%s'",
            sha1($_POST['password']),
            $_SESSION['username']
        );
        $this->db->query($sql);
    }

}
