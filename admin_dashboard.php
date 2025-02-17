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
    <input type="text" name="catagory" placeholder="Catagory" required><br>
    <input type="number" name="stock" placeholder="Stock" required><br>
    <input type="file" name="image" required><br>
    <button type="submit" name="add_item">Add Item</button>
</form>

<?php
$conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

if (isset($_POST['add_item'])) {
    $name = $_POST['fname'];
    $price = $_POST['price'];
    $catagory = $_POST['catagory_id'];
    $stock = $_POST['stock'];

    // Handle image upload
    $image_path = "uploads/" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);

    $stmt = $conn->prepare("INSERT INTO tb_menu (fname, description, price, image, catagory_id, stock) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image_path , $catagory, $stock);
    $stmt->execute();

    echo "Menu item added!";
}
?>
<a href="admin_logout.php">Logout</a>


