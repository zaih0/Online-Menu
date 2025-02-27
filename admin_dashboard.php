<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/admin.css">
<div id="add_item">
<form method="POST" enctype="multipart/form-data">
<select name="day" required>
    <option value="">Select Day</option>
    <option value="monday">Monday</option>
    <option value="tuesday">Tuesday</option>
    <option value="wednesday">Wednesday</option>
    <option value="thursday">Thursday</option>
    <option value="friday">Friday</option>
</select><br>


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
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_onlinemenu", "admin", "admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $icon = $_POST['icon'];
    $day = $_POST['day'];

    // Handle image upload
    $image_path = "uploads/" . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
        die("Failed to upload image.");
    }

    $valid_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    if (!in_array($day, $valid_days)) {
        die("Invalid day selected.");
    }

    // Icon path
    $icon_path = "{$icon_dir}{$icon}";

    try {
        $stmt = $conn->prepare("INSERT INTO tb_menu_$day (fname, price, image, category, stock, icon) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $image_path, $category, $stock, $icon_path]);
        echo "Menu item added!";
        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Execute failed: " . $e->getMessage());
    }
}

$conn = null;
?>

<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_onlinemenu", "admin", "admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

echo "<h2>Monday Menu</h2>";
try {
    $result = $conn->query("SELECT * FROM tb_menu_monday");

    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr id='row_{$row['id']}'>
                <td><input type='text' value='{$row['fname']}' id='name_{$row['id']}'></td>
                <td><input type='number' value='{$row['price']}' id='price_{$row['id']}'></td>
                <td><input type='number' value='{$row['stock']}' id='stock_{$row['id']}'></td>
                <td>{$row['category']}</td>
                <td>
                    <img src='{$row['icon']}' width='30'><br>
                    <select id='icon_{$row['id']}'>
                        <option value=''>Select Icon</option>";
                        foreach ($icons as $icon) {
                            echo "<option value='$icon' " . ($row['icon'] == "assets/$icon" ? "selected" : "") . ">$icon</option>";
                        }
        echo "      </select>
                </td>
                <td>
                    <button onclick='updateItem({$row['id']}, {$day})'>Save</button>

                    <button onclick='deleteItem({$row['id']} ?>, 'monday)'>Delete</button>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
echo "<br>";
echo "<h2>Tuesday Menu</h2>";

try {
    $result = $conn->query("SELECT * FROM tb_menu_tuesday");

    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr id='row_{$row['id']}'>
                <td><input type='text' value='{$row['fname']}' id='name_{$row['id']}'></td>
                <td><input type='number' value='{$row['price']}' id='price_{$row['id']}'></td>
                <td><input type='number' value='{$row['stock']}' id='stock_{$row['id']}'></td>
                <td>{$row['category']}</td>
                                <td>
                    <img src='{$row['icon']}' width='30'><br>
                    <select id='icon_{$row['id']}'>
                        <option value=''>Select Icon</option>";
                        foreach ($icons as $icon) {
                            echo "<option value='$icon' " . ($row['icon'] == "assets/$icon" ? "selected" : "") . ">$icon</option>";
                        }
        echo "      </select>
                </td>
                <td>
                    <button onclick='updateItem({$row['id']})'>Save</button>
                    <button onclick='deleteItem({$row['id']})'>Delete</button>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

echo "<br>";
echo "<h2>Wednesday Menu</h2>";

try {
    $result = $conn->query("SELECT * FROM tb_menu_wednesday");

    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr id='row_{$row['id']}'>
                <td><input type='text' value='{$row['fname']}' id='name_{$row['id']}'></td>
                <td><input type='number' value='{$row['price']}' id='price_{$row['id']}'></td>
                <td><input type='number' value='{$row['stock']}' id='stock_{$row['id']}'></td>
                <td>{$row['category']}</td>
                                <td>
                    <img src='{$row['icon']}' width='30'><br>
                    <select id='icon_{$row['id']}'>
                        <option value=''>Select Icon</option>";
                        foreach ($icons as $icon) {
                            echo "<option value='$icon' " . ($row['icon'] == "assets/$icon" ? "selected" : "") . ">$icon</option>";
                        }
        echo "      </select>
                </td>
                <td>
                    <button onclick='updateItem({$row['id']})'>Save</button>
                    <button onclick='deleteItem({$row['id']})'>Delete</button>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

echo "<br>";
echo "<h2>Thursday Menu</h2>";

try {
    $result = $conn->query("SELECT * FROM tb_menu_thursday");

    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr id='row_{$row['id']}'>
                <td><input type='text' value='{$row['fname']}' id='name_{$row['id']}'></td>
                <td><input type='number' value='{$row['price']}' id='price_{$row['id']}'></td>
                <td><input type='number' value='{$row['stock']}' id='stock_{$row['id']}'></td>
                <td>{$row['category']}</td>
                                <td>
                    <img src='{$row['icon']}' width='30'><br>
                    <select id='icon_{$row['id']}'>
                        <option value=''>Select Icon</option>";
                        foreach ($icons as $icon) {
                            echo "<option value='$icon' " . ($row['icon'] == "assets/$icon" ? "selected" : "") . ">$icon</option>";
                        }
        echo "      </select>
                </td>
                <td>
                    <button onclick='updateItem({$row['id']})'>Save</button>
                    <button onclick='deleteItem({$row['id']})'>Delete</button>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

echo "<br>";
echo "<h2>Friday Menu</h2>";

try {
    $result = $conn->query("SELECT * FROM tb_menu_friday");

    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr id='row_{$row['id']}'>
                <td><input type='text' value='{$row['fname']}' id='name_{$row['id']}'></td>
                <td><input type='number' value='{$row['price']}' id='price_{$row['id']}'></td>
                <td><input type='number' value='{$row['stock']}' id='stock_{$row['id']}'></td>
                <td>{$row['category']}</td>
                                <td>
                    <img src='{$row['icon']}' width='30'><br>
                    <select id='icon_{$row['id']}'>
                        <option value=''>Select Icon</option>";
                        foreach ($icons as $icon) {
                            echo "<option value='$icon' " . ($row['icon'] == "assets/$icon" ? "selected" : "") . ">$icon</option>";
                        }
        echo "      </select>
                </td>
                <td>
                    <button onclick='updateItem({$row['id']})'>Save</button>
                    <button onclick='deleteItem({$row['id']})'>Delete</button>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

$conn = null;
?>
<script>
    function updateItem(id, day) {
        let name = document.getElementById(`name_${id}`).value;
        let price = document.getElementById(`price_${id}`).value;
        let stock = document.getElementById(`stock_${id}`).value;
        let icon = document.getElementById(`icon_${id}`).value;

        fetch('edit_item.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&name=${name}&price=${price}&stock=${stock}&day=${day}&icon=${icon}`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Debugging
            if (data === "Success") {
                alert("Item updated successfully!");
            } else {
                alert("Error updating item: " + data);
            }
        });
    }

    function deleteItem(id, day) {
        if (confirm("Are you sure you want to delete this item?")) {
            fetch('delete_item.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&day=${day}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Deleted") {
                    document.getElementById(`row_${id}`).remove();
                    alert("Item deleted!");
                } else {
                    alert("Error deleting item: " + data);
                }
            });
        }
    }

</script>


<a href="admin_logout.php">Logout</a>