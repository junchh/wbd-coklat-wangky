<?php 

require_once 'config.php';

if(isset($_POST['username'])) {

    
    $query = $con->prepare("INSERT INTO `users` (username, password, email, superuser) VALUES (?, ?, ?, ?)");
    
    $query->bind_param("sssi", $username, $password, $email, $super_user);
    
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $super_user = 0;
    $query->execute();

    $user_id = $query->insert_id;

    //set to expire in 1 hour
    $expire = 3600;
    $time = time() + $expire;

    $date = new DateTime();
    $date->setTimestamp($time);
    $expire_date = $date->format('Y-m-d H:i:s');

    $hash = md5(time() . $user_id . $username);

    if($con->query("INSERT INTO `sessions` (session_id, user_id, expire_date) VALUES ('" . $hash . "', '" . $user_id . "', '" . $expire_date  . "')")) {

        $payload = ["token" => $hash, "expire" => $expire];
        $result = ["status" => "success", "description" => "user successfully registered", "payload" => $payload];
        echo json_encode($result);
    } else {
        $result = ["status" => "error", "description" => $con->error];
        exit(json_encode($result));
    }

    

} else {
    $result = ["status" => "error", "description" => "This method is not supported."];
    exit(json_encode($result));
}