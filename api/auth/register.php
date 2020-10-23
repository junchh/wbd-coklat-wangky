<?php 

require_once '../config.php';

// If username is set...
if(isset($_POST['username'])) {
    // Default values
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $super_user = 0;

    // Check if username/email has been taken
    $query = $con->prepare("SELECT `username` FROM `users` WHERE `username` = ? AND `email` = ?");
    $query->bind_param("ss", $username, $email);
    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    // Get query result
    $query_result = $query->get_result();
    if($query_result->num_rows > 0) {
        // Username/email is taken
        $result = ["status" => "duplicate", "description" => "Username or Email already exist!"];
        http_response_code(400);
        exit(json_encode($result));
    }
    
    // Create new user
    $query = $con->prepare("INSERT INTO `users` (username, name, password, email, superuser) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("ssssi", $username, $name, $password, $email, $super_user);
    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    $user_id = $query->insert_id;

    // Set session to expire in 1 hour
    $expire = 3600;
    $time = time() + $expire;

    // Generate token using current time
    $date = new DateTime();
    $date->setTimestamp($time);
    $expire_date = $date->format('Y-m-d H:i:s');
    $hash = md5(time() . $user_id . $username);

    // Create new session in DB
    if(!$con->query("INSERT INTO `sessions` (session_id, user_id, expire_date) VALUES ('" . $hash . "', '" . $user_id . "', '" . $expire_date  . "')")) {
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    // Return token in payload
    $payload = ["token" => $hash];
    $result = ["status" => "success", "description" => "user successfully registered", "payload" => $payload];
    echo json_encode($result); 
} else {
    // Username not supplied
    $result = ["status" => "error", "description" => "This method is not supported."];
    http_response_code(400);
    exit(json_encode($result));
}