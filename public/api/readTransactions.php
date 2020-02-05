<?php

    //ANVÄNDS EJ, var skapad för test

    include_once './classes/transactions.php';
    include_once './classes/db.php';

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    //database connection and user object
    $database = new DB();
    $db = $database->connect();
 
    // initialize object
    $transaction = new Transaction($db);

    // query users
    $stmt = $transaction->read();
    $num = $stmt->rowCount();
 
    // check if more than 0 record found
    if ($num > 0) {
 
        // users array
        $transaction = array();
        $transactions_arr["data"] = array();
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
 
            // transaction_id, from_amount, from_account, to_amount, to_account

            $transaction_item = array(
                "transaction_id" => $transaction_id,
                "from_amount" => $from_amount,
                "from_account" => $from_account,
                "to_amount" => $to_amount,
                "to_account" => $to_account
            );
 
            array_push($transactions_arr['data'], $transaction_item);
        }
 
        // set response code - 200 OK
        http_response_code(200);

        // show users data in json format
        echo json_encode($transactions_arr);
    } else {
 
        // set response code - 404 Not found
        http_response_code(404);
 
        // tell the user no users found
        echo json_encode(array("message" => "No users found."));
    }
