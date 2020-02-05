<?php

class DB
{
    // private $server;
    private $socket;
    private $user;
    private $pass;
    private $dbname;
    // private $charset;
    public $conn;

    public function connect()
    {
        $this->server = "127.0.0.1";
        $this->socket = "/Applications/MAMP/tmp/mysql/mysql.sock";
        $this->user = "root";
        $this->pass = "root";
        $this->dbname = "bank";
        // $this->charset = "utf8mb4";

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:unix_socket=" . $this->socket . ";dbname=" . $this->dbname, $this->user, $this->pass);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
