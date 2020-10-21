<?php 

require_once 'config.php';

$user_id = isLoggedin($con);
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    exit(json_encode($result));   
}

$query = $con->query("SELECT * FROM `users` WHERE `id` = '" . $user_id . "'");

$payload = $query->fetch_assoc();

$result = ["status" => "success", "description" => "retrieved userdata", "payload" => $payload];
echo json_encode($result); 
