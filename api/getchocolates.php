<?php 

require_once 'config.php';

$user_id = isLoggedin();
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    exit(json_encode($result));   
}

