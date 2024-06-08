<?php

class Conexion extends PDO
{
    private $server = "localhost";
    private $db = "hackaton";
    private $user = "root";
    private $password = "";

    public function __construct()
    {
        try {
            parent::__construct('mysql:host=' . $this->server . ';dbname=' . $this->db . ';charset=utf8', $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
?>
