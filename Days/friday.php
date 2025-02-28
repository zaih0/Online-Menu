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
    <div id="Sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="../index.php">Monday</a>
        <a href="tuesday.php">Tuesday</a>
        <a href="wednesday.php">Wednesday</a>
        <a href="thursday.php">Thursday</a>
        <a href="https://meescatering.nl/werken-in-de-catering/">Vacatures</a>
        <a href="https://meescatering.nl/contact/">Contact</a>
        <div id="google_translate_element"></div>

    </div>

    <div id="main">

        <div id="topbalk">
            <div class="menu" onclick="openNav()">
                <div class="stripe1 stripe"></div>
                <div class="stripe2 stripe"></div>
                <div class="stripe3 stripe"></div>
            </div>
            <a href="../index.php"><div class="logo"><img src="../logo-mees/logo-mees.svg" alt="MEES??"></div></a>
            <a href="../opening-times.php" class="opening-times"><img src="../logo-mees/clock.png" alt="clock icon"></a>
        </div>
        <h1 style="display: flex; justify-content: center;">Friday Menu</h1>

        <?php
            $conn = new mysqli("localhost", "admin", "admin", "db_onlinemenu");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM tb_menu_friday");

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
    echo "</div>";

    $conn->close();
    ?>

    <script>
    function loadMenu() {
        fetch('../Fetch/fetch_friday.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu-section').innerHTML = data;
        });
    }

    function openNav() {
            if (window.innerWidth <= 480) {
                document.getElementById("Sidenav").style.width = "100%"; 
                document.getElementById("main").style.marginLeft = "0"; 
            } else {
                document.getElementById("Sidenav").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
            }

            
        }

        function closeNav() {
        document.getElementById("Sidenav").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
        document.body.style.backgroundColor = "white";
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
            {pageLanguage: 'en'}, // Change 'en' to your default language if different
            'google_translate_element'
            );
        }


    setInterval(loadMenu, 5000); // Refresh every 5 seconds
    </script>
        <script type="text/javascript" 
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

</body>
</html>

