<?php 

require_once 'config.php';

if(isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = $_POST['token'];
    
    $query = $con->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
    
    $query->bind_param("ss", $username, $password);
    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();
    
    if($query_result->num_rows != 1){
        $result = ["status" => "auth_failed", "description" => "no such user!."];
        exit(json_encode($result));
    }

    



    $payload = ["token" => $hash, "expire" => $expire];
    $result = ["status" => "success", "description" => "user successfully registered", "payload" => $payload];
    echo json_encode($result); 

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}