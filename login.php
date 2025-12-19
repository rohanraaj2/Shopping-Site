<!DOCTYPE html>
<html>
<head>
	<title>Please log in</title>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body class='contact'>
	<p align="right">
		<button id="toggleDarkMode">Dark Mode</button>
		<button id="returnHome">Home</button>
	</p>
	<?php session_start(); include 'cartIcon.php'; ?>
<header>
<h1>Please log in with your credentials</h1><br>
</header>
<form action='processLogin.php' method='PUT'>
	<p><label for=uName>Username : </label><input type='text' id=uName ' name=userName'required></p>
	<p><label for=password>Password : </label><input type='password' id=password 'name=passkey' oninput='validatePasswordStrength()' required></p>
	<p id='passwordStrength' style='display:none; margin-left: 100px;'></p>
	<!-- <input type='submit' value='Login'> -->
</form>
<button onclick='checkCredentials()'>Login</button>
<a href='register.php'><button>Register here</button></a>
<br><br>
<a href='index.php'>Back to homepage</a>



<script src="script.js"></script>
</body>
</html>