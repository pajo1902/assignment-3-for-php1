<?php

class Transaction {

    private $conn;

    public $transaction_id;
    public $from_amount;
    public $from_account;
    public $to_amount;
    public $to_account;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read transactions
    public function read()
    {
        $query = 'SELECT transaction_id, from_amount, from_account, to_amount, to_account FROM transactions';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //setting variables for create()
    public function setFromAmount($from_amount)
    {
        $this->from_amount = $from_amount;
    }

    public function setFromAccount($from_account)
    {
        $this->from_account = $from_account;
    }

    public function setToAmount($to_amount)
    {
        $this->to_amount = $to_amount;
    }

    public function setToAccount($to_account)
    {
        $this->to_account = $to_account;
    }

    //create transactions
    public function create($balance, $amount)
    {
        $this->checkBalance($balance, $amount);

        try {
            // select all query
            $query = "INSERT INTO transactions (from_amount, from_account, to_amount, to_account)
            VALUES (:fromAmount, :fromAccount, :toAmount, :toAccount)";

            // prepare query statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fromAmount', $this->from_amount);
            $stmt->bindParam(':fromAccount', $this->from_account);
            $stmt->bindParam(':toAmount', $this->to_amount);
            $stmt->bindParam(':toAccount', $this->to_account);
            
            $stmt->execute();
            return $stmt;
        
        //om försöket att executa queryn misslyckades fånga då upp the exception och stoppa koden 
        } catch (Exception $e) {
            die("The query doesnt work" . $e);
        }
    }

    public function getBalance($from_account) {
        $query = "SELECT balance FROM vw_users WHERE account_id = :account";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':account', $this->from_account);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return $data[0]["balance"];
    }

    //check if balance is less than amount or smaller than zero
    public function checkBalance($balance, $amount) {
        if ($balance < $amount || $balance < 0) {
            throw new \Exception("Det är för lite pengar på ditt konto!");
        }
        return true;
    }
}
