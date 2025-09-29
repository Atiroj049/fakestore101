<?php
include "db.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['title'],$data['price'],$data['description'],$data['category'],$data['image'])){
    $stmt = $conn->prepare("INSERT INTO products (title,price,description,category,image) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sdsss",$data['title'],$data['price'],$data['description'],$data['category'],$data['image']);
    if($stmt->execute()){
        echo json_encode(["success"=>true,"message"=>"Product added successfully","id"=>$conn->insert_id]);
    } else {
        echo json_encode(["success"=>false,"error"=>$stmt->error]);
    }
}

$conn->close();
?>
