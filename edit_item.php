<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $day = $_POST['day'];

    $valid_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    if (!in_array($day, $valid_days)) {
        die("Invalid day.");
    }

    try {
        $stmt = $conn->prepare("UPDATE tb_menu_$day SET fname=?, price=?, stock=? WHERE id=?");
        $stmt->execute([$name, $price, $stock, $id]);
        echo "Success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

