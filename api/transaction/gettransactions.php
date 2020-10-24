<?php 

require_once '../config.php';

$user_id = isLoggedin($con);
if($user_id == -1){
    $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
    exit(json_encode($result));   
}

$query = $con->query(
    "SELECT `name`, `amount`, `price`, `date`, `address`
    FROM `transactions` JOIN `chocolates` ON `transactions`.`chocolate_id` = `chocolates`.`id`
    WHERE `buyer_id`='" . $user_id . "' ORDER BY `date` DESC"
);

$payload = [];
while($row = $query->fetch_assoc()) {
    array_push($payload, transformRow($row));
}

$result = ["status" => "success", "description" => "retrieved all transactions for current user", "payload" => $payload];
echo json_encode($result); 
