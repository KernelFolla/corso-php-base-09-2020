<?php

class UserLogsRepository
{
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /*
     * salva un nuovo record di log a database dell'azione passata
     */
    public function trackAction($username, $action)
    {
        $sql = sprintf("INSERT INTO users_logged (username, action) VALUES ('%s','%s')", $username, $action);
        $this->db->query($sql);
    }

    public function getActions($limit = 10)
    {
        $sql = "SELECT * FROM users_logged ORDER BY id DESC LIMIT ".$limit;

        return $this->db->getList($sql);
    }

    /*
     * cancella un record di log dal database
     */
    public function deleteAction($id)
    {
        $sql = sprintf('DELETE FROM users_logged WHERE id = %d ', $id);
        $this->db->query($sql);
    }

}
