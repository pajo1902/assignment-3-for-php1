<?php
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");

    //includes all files with "classes" in the name automatically
    include 'includes/autoloader.inc.php';

    //to identify what request
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $json_data = file_get_contents('php://input');

    //här decodar jag datan från json till ett php-objekt
    $data_obj = json_decode($json_data, true);

    $database = new DB();
    $db = $database->connect();

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
            if ($tryTransaction = $transaction->create($transaction->getBalance($from_account), $to_amount)) {
                echo ("Transaction was succesfull");
                return $tryTransaction;
            }
        } catch (Exception $err) {
            echo 'Message:' . $err->getMessage();
        }
        
        //felhantering
        if (!empty($tryTransaction)) {
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
