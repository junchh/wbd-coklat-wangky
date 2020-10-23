<?php 

require_once '../config.php';

// If username is set...
if(isset($_POST['username'])) {
    // POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Select username entry
    $query = $con->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $query->bind_param("s", $username);
    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    // Check entry validity
    $query_result = $query->get_result();
    if($query_result->num_rows != 1) {
        $result = ["status" => "auth_failed_nouser", "description" => "no such user!."];
        http_response_code(401);
        exit(json_encode($result));
    }

    // Verify password validity
    $userData = $query_result->fetch_assoc();
    if(!password_verify($password, $userData['password'])) {
        $result = ["status" => "auth_failed_pass", "description" => "invalid password!."];
        http_response_code(400);
        exit(json_encode($result));
    }

    // Get user id
    $user_id = $userData['id'];

    // Set to session to expire in 1 hour
    $expire = 3600;
    $time = time() + $expire;

    // Generate unique token based on time
    $date = new DateTime();
    $date->setTimestamp($time);
    $expire_date = $date->format('Y-m-d H:i:s');
    
    $hash = md5(time() . $user_id . $username);

    // Input session to DB
    if(!$con->query("INSERT INTO `sessions` (session_id, user_id, expire_date) VALUES ('" . $hash . "', '" . $user_id . "', '" . $expire_date  . "')")) {
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    // Return token as payload
    $payload = ["token" => $hash];
    $result = ["status" => "success", "description" => "login ok", "payload" => $payload];
    echo json_encode($result); 

} else {
    // Username is not set
    $result = ["status" => "error", "description" => "This method is not supported."];
    http_response_code(404);
    exit(json_encode($result));
}