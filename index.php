<?php
$welcomeTitle = "Welcome to our webstore through PHP";
?>
<!DOCTYPE html>
<html>    
    <head>
        <p align="right"><button id="toggleDarkMode">Dark Mode</button></p>
        <title>Web Store 15</title>
        <link rel="stylesheet" type="text/css" href="mystyle.css">
    </head>
    
    <body class="index">
        <header>
            <h1><?php echo $welcomeTitle; ?></h1>

            <ul>
                <li>Tops</li>
                <ul>
                    <li><a href="hoodiesList.php">Hoodies</a></li>
                    <li><a href="jacketsList.php">Jackets</a></li>
                </ul>
            </ul>

            <ul>
                <li>Bottoms</li>
                <ul>
                    <li><a href="pantsList.php">Pants</a></li>
                    <li><a href="pyjamasList.php">Pyjamas</a></li>
                </ul>
            </ul>
        </header>
        
        <footer>
            <a href="login.php">Login</a>/<a href="register.php" target="_blank">Register</a><br>
            <a href="about.php">About Us</a><br>
            <a href="customer.php">My profile</a><br>
            <p>If you would like to <em>logout</em> please click
            <a href="logout.php" target="_blank">here</a></p>
        </footer>

        <script src="script.js"></script>
    </body>
</html>

