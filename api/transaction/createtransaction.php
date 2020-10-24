<?php 

require_once '../config.php';

if(isset($_POST['chocolate_id'])){
    $buyer_id = isLoggedin($con);
    if($buyer_id == -1){
        $result = ["status" => "invalid_login", "description" => "Invalid login information!"];
        exit(json_encode($result));   
    }

    if(isAdmin($con, $buyer_id)){
        $result = ["status" => "unauthorized", "description" => "Admins cannot create transactions!"];
        exit(json_encode($result));  
    }

    $chocolate_id = $_POST['chocolate_id'];
    $amount = $_POST['amount'];

    // Check chocolate stock
    $query = $con->prepare("SELECT `current_quantity` FROM `chocolates` WHERE `id` = ?");
    $query->bind_param("i", $chocolate_id);
    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    $query_result = $query->get_result();
    $row = $query_result->fetch_assoc();
    if(!$row){
        $result = ["status" => "invalid_chocolate", "description" => "No chocolate with the requested ID."];
        http_response_code(400);
        exit(json_encode($result));
    }
    
    if($row['current_quantity'] < $amount){
        $result = ["status" => "insufficient_amount", "description" => "Not enough stock of chocolate with the requested ID."];
        http_response_code(400);
        exit(json_encode($result));
    }
    
    // In the format of 'YYYY-MM-DD HH:mm:ss' e.g. '2010-03-01 00:00:00'
    $date = $_POST['date'];
    $address = $_POST['address'];

    // Add transaction
    $query = $con->prepare(
        "INSERT INTO `transactions`(`buyer_id`, `chocolate_id`, `amount`, `date`, `address`)
        VALUES (?, ?, ?, ?, ?)"
    );

    $query->bind_param("iiiss", $buyer_id, $chocolate_id, $amount, $date, $address);    

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }

    // Decrement stock
    $query = $con->prepare(
        "UPDATE `chocolates` 
        SET `quantity_sold`=`quantity_sold`+?, `current_quantity`=`current_quantity`-?
        WHERE `id` = ?"
    );

    $query->bind_param("iii", $amount, $amount, $chocolate_id); 

    if(!$query->execute()){
        $result = ["status" => "error", "description" => $con->error];
        http_response_code(500);
        exit(json_encode($result));
    }
        
    $result = ["status" => "success", "description" => "created transactions for current user"];
    echo json_encode($result);     
}
else{
    // Return error code
    $result = ["status" => "error", "description" => "This method is not supported."];
    http_response_code(404);
    exit(json_encode($result));
}

