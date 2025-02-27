<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $icon = $_POST['icon'];


    $valid_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    if (!in_array($day, $valid_days)) {
        die("Invalid day.");
    }

    // Dynamically set table name
    $table_name = "tb_menu_" . $day;

    try {
        $stmt = $conn->prepare("UPDATE $table_name SET fname=?, price=?, stock=?, icon=? WHERE id=?");
        $stmt->bind_param("sdisi", $name, $price, $stock, $icon, $id);
        $stmt->execute();

        echo "Success";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (!isset($_POST['day']) || !in_array($day, $valid_days)) {
    die("Invalid day. Received: " . htmlspecialchars($day));
}
?>


