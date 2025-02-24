<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
?>
<link rel="stylesheet" href="./css/admin.css">
<div id="add_item">
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Food Name" required><br>
    <input type="number" name="price" step="0.01" placeholder="Price" required><br>
    <input type="text" name="category" placeholder="Category" required><br>
    <input type="number" name="stock" placeholder="Stock" required><br>
    <input type="file" name="image" required><br>
    <select name="icon" required>
        <option value="">Select Icon</option>
        <?php
        $icon_dir = 'assets/';
        $icons = array_diff(scandir($icon_dir), ['..', '.']);
        foreach ($icons as $icon) {
            echo "<option value='$icon'>$icon</option>";
        }
        ?>
    </select><br>
    <button type="submit" name="add_item">Add Item</button>
</form>
</div>

<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}

if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $icon = $_POST['icon'];

    // Handle image upload
    $image_path = "uploads/" . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
        die("Failed to upload image.");
    }

    // Icon path
    $icon_path = "{$icon_dir}{$icon}";

    $stmt = $conn->prepare("INSERT INTO tb_menu (fname, price, image, catagory_id, stock, icon) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: {$conn->error}");
    }

    $stmt->bind_param("sdsiss", $name, $price, $image_path, $category, $stock, $icon_path);

    if ($stmt->execute()) {
        echo "Menu item added!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        die("Execute failed: {$stmt->error}");
    }

}

$conn->close();
?>
<a href="admin_logout.php">Logout</a>
