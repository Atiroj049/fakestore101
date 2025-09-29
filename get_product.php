<?php
include "db.php";
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);
$conn->close();
?>
