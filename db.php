<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fakestore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => $conn->connect_error]));
}
?>
