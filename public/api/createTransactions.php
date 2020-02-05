<?php
     // required headers
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");

    include_once './classes/transactions.php';
    include_once './classes/db.php';

    $requestMethod = $_SERVER["REQUEST_METHOD"]; //to identify what request

    $json_data = file_get_contents('php://input');

    $data_obj = json_decode($json_data, true); //här decodar jag datan från json till ett php-objekt
    echo $data_obj['from_account']; //här kan jag plocka ut vad jag behöver ifrån datan som skickades

    //database connection and user object
    $database = new DB();
    $db = $database->connect();
 
    // initialize object
    $transaction = new Transaction($db);
    
switch ($requestMethod) {
    case "POST":
        $from_amount = $data_obj['from_amount'];
        $from_account = $data_obj['from_account'];
        $to_amount = $data_obj['to_amount'];
        $to_account = $data_obj['to_account'];

        $transaction->setFromAmount($from_amount);
        $transaction->setFromAccount($from_account);
        $transaction->setToAmount($to_amount);
        $transaction->setToAccount($to_account);

        //felhantering
        if (!empty($transaction->create())) {
            $js_encode = json_encode(array('status'=>true, 'message'=>'Transaction created successfully'));
        } else {
            $js_encode = json_encode(array('status'=>false, 'message'=>'Transaction creation failed.'));
        }
        echo $js_encode;
        break;
    default:
        break;
}

    // query transactions
    // $stmt = $transaction->create();



    // $num = $stmt->rowCount();
 
    // // check if more than 0 record found
    // if ($num > 0) {

    // };
