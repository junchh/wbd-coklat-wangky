<?php

require_once '../config.php';

// Check if user is logged in
$user_id = isLoggedin($con);

// If user is not logged in and not admin, unauthorize
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    http_response_code(401);
    exit(json_encode($result));   
}

$is_admin = isAdmin($con, $user_id);

if(!$is_admin){
    $result = ["status" => "invalid_previlege", "description" => "Invalid previlege!"];
    http_response_code(401);
    exit(json_encode($result));   
}

$name = $_POST["name"];
$price = $_POST["price"];
$description = $_POST["description"];
$quantity_sold = 0;
$current_quantity = $_POST["currentQuantity"];

$target_dir = __DIR__ . '/../../static/images/';
$target_filename = time() . "-" . basename($_FILES["image"]["name"]);
$target_filepath = $target_dir . $target_filename;
$imageType = strtolower(pathinfo($target_filepath,PATHINFO_EXTENSION));

if(!getimagesize($_FILES["image"]["tmp_name"]) && $imageType !== "jpg" && $imageType !== "png" && $imageType !== "jpeg") {
  $result = ["status" => "error", "description" => "invalid image"];
  http_response_code(400);
  exit(json_encode($result));
}

if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target_filepath)) {
  $result = ["status" => "error", "description" => "upload failed"];
  http_response_code(500);
  exit(json_encode($result));
}

$image_path = "/static/images/" . $target_filename;
$query = $con->prepare("INSERT INTO `chocolates` (name, price, description, image_path, quantity_sold, current_quantity) VALUES (?, ?, ?, ?, ?, ?)");
$query->bind_param("sissii", $name, $price, $description, $image_path, $quantity_sold, $current_quantity);
if(!$query->execute()){
  $result = ["status" => "error", "description" => $con->error];
  http_response_code(500);
  exit(json_encode($result));
}

$result = ["status" => "success", "description" => "chocolate creation successful"] ;
exit(json_encode($result));


