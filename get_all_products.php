<?php
include "db.php";
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($products);
$conn->close();
?>
