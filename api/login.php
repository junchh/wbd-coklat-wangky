<?php 

require_once 'config.php';

if(isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $query = $con->prepare("SELECT * FROM `users` WHERE `username` = ?");
    
    $query->bind_param("s", $username);
    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();
    
    if($query_result->num_rows != 1) {
        $result = ["status" => "auth_failed", "description" => "no such user!."];
        exit(json_encode($result));
    }

    $userData = $query_result->fetch_assoc();

    if(!password_verify($password, $userData['password'])) {
        $result = ["status" => "auth_failed", "description" => "invalid password!."];
        exit(json_encode($result));
    }


    $user_id = $userData['id'];

    //set to expire in 1 hour
    $expire = 3600;
    $time = time() + $expire;

    $date = new DateTime();
    $date->setTimestamp($time);
    $expire_date = $date->format('Y-m-d H:i:s');

    $hash = md5(time() . $user_id . $username);

    if(!$con->query("INSERT INTO `sessions` (session_id, user_id, expire_date) VALUES ('" . $hash . "', '" . $user_id . "', '" . $expire_date  . "')")) {

        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $payload = ["token" => $hash];
    $result = ["status" => "success", "description" => "login ok", "payload" => $payload];
    echo json_encode($result); 

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}