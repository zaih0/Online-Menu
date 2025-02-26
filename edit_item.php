<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$stock = $_POST['stock'];

$stmt = $conn->prepare("UPDATE tb_menu SET fname=?, price=?, stock=? WHERE id=?");
$stmt->bind_param("sdii", $name, $price, $stock, $id);

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
