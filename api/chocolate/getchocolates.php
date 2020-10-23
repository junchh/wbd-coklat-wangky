<?php 

require_once('../config.php');

// Check if user is logged in
$user_id = isLoggedin($con);

// If user is not logged in, unauthorize
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    http_response_code(401);
    exit(json_encode($result));
}

// Get all chocolates from DB
$query = $con->query("SELECT * FROM `chocolates`");
$payload = [];
while($row = $query->fetch_assoc()) {
    array_push($payload, transformRow($row));
}

// Return chocolates in payload
$result = ["status" => "success", "description" => "retrieved all chocolates", "payload" => $payload];
echo json_encode($result); 
