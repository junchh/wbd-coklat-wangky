<?php 

require_once 'config.php';

if(isset($_GET['sessiontoken'])) {

    $headers = getallheaders();
    $token = $headers['sessiontoken'];

    $query = $con->prepare("SELECT * FROM `sessions` WHERE `session_id` = ?");
    $query->bind_param("s", $token);

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    $query_result = $query->get_result();

    if($query_result->num_rows == 0) {
        $result = ["status" => "no_session", "description" => "Session doesn't exist!"];
        exit(json_encode($result));
    }

    $session_data = $query_result->fetch_assoc();
    
    $expired = strtotime($session_data['expire_date']);
    $now = time();
    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    if($now > $expired) {
        $result = ["status" => "session_expired", "description" => "Session already expired!"];
        exit(json_encode($result));
    }

    $result = ["status" => "success", "description" => "login valid."];
    echo json_encode($result); 

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}