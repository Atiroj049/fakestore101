<?php
header('Content-Type: application/json');
include 'db.php'; // ไฟล์เชื่อมต่อ DB

if(!isset($_GET['id'])){
    echo json_encode(['status'=>0,'message'=>'No ID provided']);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo json_encode(['status'=>1,'message'=>'Product deleted successfully']);
    } else {
        echo json_encode(['status'=>0,'message'=>'Product not found']);
    }

    $stmt->close();
    $conn->close();

} catch(Exception $e){
    echo json_encode(['status'=>0,'message'=>'Error: '.$e->getMessage()]);
}
