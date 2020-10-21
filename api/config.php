<?php 
header('Content-Type: application/json');

define("HOST", 'localhost');
define("USER", 'root');
define('PASS', 'password');
define('DBNAME', 'choco_factory');

$con = new mysqli(HOST, USER, PASS, DBNAME);

if($con->connect_errno) {

    $result = ["status" => "error", "description" => "cannot connect to MySQL database."];
    exit(json_encode($result));
}


