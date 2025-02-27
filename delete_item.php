<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $day = $_POST['day'];

    $valid_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    if (!in_array($day, $valid_days)) {
        die("Invalid day.");
    }

    try {
        $stmt = $conn->prepare("DELETE FROM tb_menu_$day WHERE id=?");
        $stmt->execute([$id]);
        echo "Deleted";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

