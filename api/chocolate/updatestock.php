<?php

require_once '../config.php';

// Check if user is logged in
$user_id = isLoggedin($con);

// If user is not logged in, unauthorize
if($user_id == -1 && !isAdmin($con, $user_id)){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    http_response_code(401);
    exit(json_encode($result));   
}

$id = $_POST["id"];
$current_quantity = $_POST["currentQuantity"];

$query = $con->prepare("SELECT * FROM `chocolates` WHERE id = ?");
$query->bind_param("i", $id);
if(!$query->execute()){
  $result = ["status" => "error", "description" => $con->error];
  http_response_code(500);
  exit(json_encode($result));
}



if($query -> get_result() -> num_rows !== 1) {
  $result = ["no_choco" => "invalid_login", "description" => "Invalid choco"];
  http_response_code(400);
  exit(json_encode($result));   
}

$query = $con->prepare("UPDATE `chocolates` SET current_quantity= ? WHERE id = ?");
$query->bind_param("ii", $current_quantity, $id);    
if(!$query->execute()){
    $result = ["status" => "error", "description" => $con->error];
    http_response_code(500);
    exit(json_encode($result));
}

$result = ["status" => "success", "description" => "chocolate stock updated."];
echo json_encode($result); 


