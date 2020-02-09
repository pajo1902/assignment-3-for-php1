<?php 
    include_once './classes/user.php';
    include_once './classes/db.php';

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    //database connection and user object
    $database = new DB();
    $db = $database->connect();
 
    // initialize object
    $user = new User($db);

    // query users
    $stmt = $user->read();
    $num = $stmt->rowCount();
 
    // check if more than 0 record found
    if ($num > 0) {
 
        // users array
        $users_arr = array();
        $users_arr["data"] = array();
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
 
            $user_item = array(
                "id" => $id,
                "firstName" => $firstname,
                "lastName" => $lastname,
                "username" => $username,
                "balance" => $balance,
                "account_id" => $account_id
            );
 
            array_push($users_arr['data'], $user_item);
        }
 
        // set response code - 200 OK
        http_response_code(200);

        // show users data in json format
        echo json_encode($users_arr);
    } else {
 
        // set response code - 404 Not found
        http_response_code(404);
 
        // tell the user no users found
        echo json_encode(array("message" => "No users found."));
    }
