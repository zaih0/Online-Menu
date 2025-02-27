<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEES Catering | Online Menu</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../logo-mees/mees_icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <div id="topbalk">
        <div class="menu">
            <div class="stripe1 stripe"></div>
            <div class="stripe2 stripe"></div>
            <div class="stripe3 stripe"></div>
        </div>
        <div class="logo"><img src="../logo-mees/logo-mees.svg" alt="MEES??"></div>
        <a href="../opening-times.php" class="opening-times"><img src="../logo-mees/clock.png" alt="clock icon"></a>
    </div>
    <h1 style="display: flex; justify-content: center;">Wednesday Menu</h1>

    <?php
        $conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM tb_menu_wednesday");

    echo "<div class='menu-container'>"; // Wrapper div for styling

    while ($row = $result->fetch_assoc()) {
        echo "<div class='menu-item'>
                <img src='../{$row['image']}' alt='{$row['fname']}' class='menu-image'>
                <h3>{$row['fname']}</h3>
                <p>Category: {$row['category']}</p>
                <p>Price: € {$row['price']}</p>
                <p>Stock: {$row['stock']}</p>
                <img src='../{$row['icon']}' class='menu-icon' title='Icon'>
            </div>";
    }

    echo "</div>";

    $conn->close();
    ?>

    <script>
    function loadMenu() {
        fetch('../Fetch/fetch_wednesday.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu-section').innerHTML = data;
        });
    }

    setInterval(loadMenu, 5000); // Refresh every 5 seconds
    </script>

</body>
</html>

