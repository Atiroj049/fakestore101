<?php
include "db.php";
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$data = json_decode(file_get_contents("php://input"), true);

if($id && isset($data['title'],$data['price'],$data['description'],$data['category'],$data['image'])){
    $stmt = $conn->prepare("UPDATE products SET title=?,price=?,description=?,category=?,image=? WHERE id=?");
    $stmt->bind_param("sdsssi",$data['title'],$data['price'],$data['description'],$data['category'],$data['image'],$id);
    if($stmt->execute()){
        echo json_encode(["success"=>true,"message"=>"Product updated successfully"]);
    } else {
        echo json_encode(["success"=>false,"error"=>$stmt->error]);
    }
}

$conn->close();
?>
