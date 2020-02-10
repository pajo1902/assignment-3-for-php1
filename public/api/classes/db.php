<?php

//använder mig av autoloadern för att ladda in .env
require_once '../../vendor/autoload.php';

\Dotenv\Dotenv::createImmutable('../../')->load();

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
        
        // $this->socket = '/Applications/MAMP/tmp/mysql/mysql.sock';
        // $this->user = 'root';
        // $this->pass = 'root';
        // $this->dbname = 'bank';

        $this->socket = getenv('DB_SOCKET');
        $this->user = getenv('DB_USER');
        $this->pass = getenv('DB_PASS');
        $this->dbname = getenv('DB_DATABASE');
        
    // DB_SOCKET="/Applications/MAMP/tmp/mysql/mysql.sock"
    // DB_USER="root"
    // DB_PASS="root"
    // DB_DATABASE="bank"

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
