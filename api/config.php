<?php 
// Set response header
header('Content-Type: application/json');

// Create MySQL connection
define("HOST", 'localhost');
define("USER", 'root');
define('PASS', 'password');
define('DBNAME', 'choco_factory');

$con = new mysqli(HOST, USER, PASS, DBNAME);

if($con->connect_errno) {
    $result = ["status" => "error", "description" => "cannot connect to MySQL database."];
    exit(json_encode($result));
}

// Check if user is logged in
function isLoggedin($con) {
    // Get token from header
    $headers = getallheaders();

    if(!isset($headers['sessiontoken'])){
        return -1;
    }
    
    $token = $headers['sessiontoken'];

    // Validate session with DB
    $query = $con->prepare("SELECT * FROM `sessions` WHERE `session_id` = ?");
    $query->bind_param("s", $token);
    if(!$query->execute()){
        return -1;
    }
    $query_result = $query->get_result();
    

    // If no valid session, return status -1 (NOT LOGGED IN)
    if($query_result->num_rows == 0) {
        return -1;
    }

    // Check if session is still valid
    $session_data = $query_result->fetch_assoc();
    $expired = strtotime($session_data['expire_date']);
    $now = time();

    // If session is no longer valid, return status -1 (NOT LOGGED IN)
    if($now > $expired) {
        return -1;
    }
    
    // Return user id (LOGGED IN)
    return $session_data['user_id']; 

}

// Convert snake_case to camelCase
function changeToCamel($string) {
    $res = "";
    $arr = explode("_", $string);
    for($i = 0; $i < count($arr); $i++) {
        if($i == 0) {
            $res .= $arr[$i];
        } else {
            $res .= ucfirst($arr[$i]);
        }
    }
    return $res;
}

// Convert keys to be in camelCase
function transformRow($arr) {
    $res = [];
    foreach($arr as $key => $value) {
        $res[changeToCamel($key)] = $value;
    }
    return $res;
}

