<?php 

require_once 'config.php';

$user_id = isLoggedin($con);
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    exit(json_encode($result));   
}

$query = $con->query("SELECT * FROM `chocolates`");

$payload = [];
while($row = $query->fetch_assoc()) {
    array_push($payload, transformRow($row));
}

echo json_encode($payload);
