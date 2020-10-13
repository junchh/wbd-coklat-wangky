<?php 

require_once 'config.php';

if(isset($_POST['username'])) {

    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $super_user = 0;

    $query = $con->prepare("SELECT `username` FROM `users` WHERE `username` = ? AND `email` = ?");
    $query->bind_param("ss", $username, $email);

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();

    if($query_result->num_rows > 0) {
        $result = ["status" => "duplicate", "description" => "Username or Email already exist!"];
        exit(json_encode($result));
    }
    
    $query = $con->prepare("INSERT INTO `users` (username, name, password, email, superuser) VALUES (?, ?, ?, ?, ?)");
    
    $query->bind_param("ssssi", $username, $name, $password, $email, $super_user);
    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $user_id = $query->insert_id;

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
    $result = ["status" => "success", "description" => "user successfully registered", "payload" => $payload];
    echo json_encode($result); 

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}