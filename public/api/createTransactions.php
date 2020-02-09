<?php
     // required headers
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");

    include_once './classes/transaction.php';
    include_once './classes/db.php';

    $requestMethod = $_SERVER["REQUEST_METHOD"]; //to identify what request

    $json_data = file_get_contents('php://input');

    $data_obj = json_decode($json_data, true); //här decodar jag datan från json till ett php-objekt
    echo $data_obj['from_account']; //här kan jag plocka ut vad jag behöver ifrån datan som skickades

    //database connection and user object
    $database = new DB();
    $db = $database->connect();
 
    // $test = 4;
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

        try {
            if ($transInfo = $transaction->create($transaction->getBalance($from_account), $to_amount)) {
                echo ("Transaction was succesfull");
                return $transInfo;
            }
        } catch (Exception $err) {
            echo 'Message:' . $err->getMessage();
        }
        
        //felhantering
        if (!empty($transInfo)) {
            $js_encode = json_encode(array('status'=>true, 'message'=>'Transaction was Successfully'), true);
        } else {
            $js_encode = json_encode(array('status'=>false, 'message'=>'Transaction failed.'), true);
        }
        header('Content-Type: application/json');
        echo $js_encode;
        break;
    default:
        break;
}
