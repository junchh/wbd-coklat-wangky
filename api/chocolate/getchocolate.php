<?php 

<<<<<<< HEAD
require_once '../config.php';
=======
require_once('../config.php');
>>>>>>> 85509f374c9ee10dbbb2c2de5ad6c9f2fc7b5183

// Check if id is set on query string
if(isset($_GET['id'])) {
    // Check if user is logged in
    $user_id = isLoggedin($con);

    // If user is not logged in, unauthorize
    if($user_id == -1){
        $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
        http_response_code(401);
        exit(json_encode($result));   
    }

    // Query for a specific chocolate by id
    $id = $_GET['id'];
    $query = $con->prepare("SELECT * FROM `chocolates` WHERE `id` = ?");
    $query->bind_param("i", $id);    
    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    // Verify result
    $query_result = $query->get_result();

    // If there is no result...
    if($query_result->num_rows != 1) {
        $result = ["status" => "no_chocolate", "description" => "no such chocolate!."];
        http_response_code(404);
        exit(json_encode($result));
    }

    // Return chocolate in payload
    $payload = transformRow($query_result->fetch_assoc());
    $result = ["status" => "success", "description" => "retrieved chocolate.", "payload" => $payload];
    echo json_encode($result); 

} else {
    // Return error code
    $result = ["status" => "error", "description" => "This method is not supported."];
    http_response_code(404);
    exit(json_encode($result));
}