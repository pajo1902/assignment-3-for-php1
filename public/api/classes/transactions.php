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

        // select all query
        $query = 'SELECT transaction_id, from_amount, from_account, to_amount, to_account FROM transactions';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
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
    public function create()
    {
        try {
            // select all query
            $query = "INSERT INTO transactions (from_amount, from_account, to_amount, to_account)
            VALUES ($this->from_amount, $this->from_account, $this->to_amount, $this->to_account)";

            // prepare query statement
            $stmt = $this->conn->prepare($query); //kolla upp

            // execute query
            $stmt->execute();

            $status = $stmt->rowCount();

            return $status;
        } catch (Exception $e) {
            die("The query doesnt work");
        }
    }
}
