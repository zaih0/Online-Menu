<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM tb_menu_thursday");

while ($row = $result->fetch_assoc()) {
    echo "<div class='menu-item'>
            <img src='{$row['image']}' alt='{$row['fname']}' class='menu-image'>
            <h3>{$row['fname']}</h3>
            <p>Category: {$row['catagory']}</p>
            <p>Price: $ {$row['price']}</p>
            <p>Stock: {$row['stock']}</p>
            <img src='{$row['icon']}' class='menu-icon' title='Icon'>
          </div>";
}

$conn->close();
?>
