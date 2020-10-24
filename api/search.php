<?php 

require_once 'config.php';

if(isset($_GET['q'])){
    $user_id = isLoggedin($con)[0];
    if($user_id == -1){
        $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
        exit(json_encode($result));   
    }

    $q = "%{$_GET['q']}%";

    $query = $con->prepare("SELECT * FROM `chocolates` WHERE `name` LIKE ? OR `description` LIKE ?");

    $query->bind_param("ss", $q, $q);

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();

    $payload = [];
    while($row = $query_result->fetch_assoc()) {
        array_push($payload, transformRow($row));
    }

    $result = ["status" => "success", "description" => "retrieved all search results", "payload" => $payload];
    echo json_encode($result); 
} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}
