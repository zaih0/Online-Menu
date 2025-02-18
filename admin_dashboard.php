<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
?>

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

<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $icon = $_POST['icon'];

    // Handle image upload
    $image_path = "uploads/" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);

    $stmt = $conn->prepare("INSERT INTO tb_menu (fname, price, image, catagory_id, stock, icon) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $name, $price, $image_path, $category, $stock, $icon);

    echo "Menu item added!";
    header("Location: admin_dashboard.php");
    exit();
}
?>
<a href="admin_logout.php">Logout</a>
