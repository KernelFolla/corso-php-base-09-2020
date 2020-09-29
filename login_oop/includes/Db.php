<?php

class Db
{
    private $db;

    public function __construct($host, $user, $pass, $name, $port)
    {
        $this->db = new mysqli($host, $user, $pass, $name, $port);
        /* check connection */
        if ($this->db->connect_errno) {
            throw new Exception("Connect failed: %s\n", $this->db->connect_error);
        }

        if ($this->db->query('select * from users limit 1') === false) {
            $this->initialize();
        }
    }

    public function query(string $sql)
    {
        $ret = $this->db->query($sql);
        if ($ret === false) {
            throw new Exception($this->db->error);
        } else {
            return $ret;
        }
    }

    public function getList($sql){
        $query = $this->db->query($sql);
        $ret = [];
        while($row = $query->fetch_object()){
            $ret[] = $row;
        }
        return $ret;
    }

    function initialize()
    {
        echo "INITIALIZING DB";
        global $db;
        $query  = '';
        $handle = @fopen(FILE_APPLICATION_SQL, "r");

        if ($handle) {
            while ( ! feof($handle)) {
                $query .= fgets($handle, 4096);

                if (substr(rtrim($query), -1) === ';') {
                    $db->query($query);
                    $query = '';
                }
            }

            fclose($handle);
        }
    }
}
