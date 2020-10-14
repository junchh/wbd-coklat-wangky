<?php 

require_once 'config.php';

if(isset($_GET['id']) && isLoggedin()) {

    $id = $_GET['id'];

    
    $query = $con->prepare("SELECT * FROM `chocolates` WHERE `id` = ?");
    
    $query->bind_param("i", $id);
    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();
    
    if($query_result->num_rows != 1) {
        $result = ["status" => "auth_failed_nouser", "description" => "no such user!."];
        exit(json_encode($result));
    }

    $userData = $query_result->fetch_assoc();

    

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}