<?php 

require_once 'config.php';

if(isset($_GET['id'])) {
    $user_id = isLoggedin($con);
    if($user_id == -1){
        $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
        exit(json_encode($result));   
    }

    $id = $_GET['id'];

    
    $query = $con->prepare("SELECT * FROM `chocolates` WHERE `id` = ?");
    
    $query->bind_param("i", $id);
    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();
    
    if($query_result->num_rows != 1) {
        $result = ["status" => "no_chocolate", "description" => "no such chocolate!."];
        exit(json_encode($result));
    }

    $payload = $query_result->fetch_assoc();

    $result = ["status" => "success", "description" => "retrieved chocolate.", "payload" => $payload];
    echo json_encode($result); 

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}