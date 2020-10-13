<?php 

require_once 'config.php';

if(isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $super_user = 0;

    $query = $con->prepare("INSERT INTO `users` (username, password, email, superuser) VALUES (?, ?, ?, ?)");
    $query->bind_param("sssi", $username, $password, $email, $super_user);

    $query->execute();

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}