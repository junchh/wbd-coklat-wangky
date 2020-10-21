<?php 
header('Content-Type: application/json');

define("HOST", 'localhost');
define("USER", 'root');
define('PASS', '123');
define('DBNAME', 'choco_factory');

$con = new mysqli(HOST, USER, PASS, DBNAME);

if($con->connect_errno) {

    $result = ["status" => "error", "description" => "cannot connect to MySQL database."];
    exit(json_encode($result));
}

function isLoggedin() {
    $headers = getallheaders();
    $token = $headers['sessiontoken'];

    $query = $con->prepare("SELECT * FROM `sessions` WHERE `session_id` = ?");
    $query->bind_param("s", $token);

    if(!$query->execute()){
        return -1;
    }

    $query_result = $query->get_result();

    if($query_result->num_rows == 0) {
        return -1;
    }

    $session_data = $query_result->fetch_assoc();
    
    $expired = strtotime($session_data['expire_date']);
    $now = time();
    

    if(!$query->execute()){
        return -1;
    }

    if($now > $expired) {
        return -1;
    }
    
    return $session_data['user_id']; 

}


