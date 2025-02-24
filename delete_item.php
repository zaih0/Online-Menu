<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM tb_menu WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Deleted";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
