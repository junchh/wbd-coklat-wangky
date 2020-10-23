<?php 

require_once '../config.php';

// Check if user is logged in
$user_id = isLoggedin($con);

// If user is not logged in, unauthorize
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    http_response_code(401);
    exit(json_encode($result));   
}

// Get user data from DB
$query = $con->query("SELECT * FROM `users` WHERE `id` = '" . $user_id . "'");

// Return user data in payload
$payload = $query->fetch_assoc();
$result = ["status" => "success", "description" => "retrieved userdata", "payload" => $payload];
echo json_encode($result); 
