<!DOCTYPE html>
<html>
<head><title>Pyjamas</title>

<p align="right">
    <button id="toggleDarkMode">Dark Mode</button>
    <button id="returnHome">Home</button>
</p>

<link rel="stylesheet" type="text/css" href="mystyle.css"></head>
<body>
	<h2>Here is the list of our pyjamas</h2>
	
	<p align='center'>
	<label for="viewSelect" ><strong>View Products :</strong></label>
	<select id="viewSelect">
    <option value="vertical">Vertically</option>
    <option value="horizontal">Horizontally</option>
	</select>
	</p>
	
	<ol id="productList">>
		<li id='Pyjamas1'>
			<img src="images/pyjamas1.webp" alt="black pyjama" width="150">
			<p><strong>Black Printed Pyjamas</strong></p>
			<p>Price: $20</p>
			<a href="Pyjamas1.php" target=_blank>View More</a>
			<input type='text' name='quantity' value=1 />
			<button onclick='addToCart(Pyjamas1)'>Add to Cart!</button>
		</li>
		
		<br><br><br><br>
		
		<li id='Pyjamas2'>
			<img src="images/pyjamas2.webp" alt="red pyjama" width="150">
			<p><strong>Red Printed Pyjamas</strong></p>
			<p>Price: $20</p>
			<a href="Pyjamas2.php" target=_blank>View More</a>
			<input type='text' name='quantity' value=1 />
			<button onclick='addToCart(Pyjamas2)'>Add to Cart!</button>
		</li>
	</ol>

	<h3>Your Shopping Cart</h3>
	<div style='margin: 20px;'>
		<p>Remove items from cart:</p>
		<button onclick="removeFromCart('black pyjama')">Remove Black Pyjama</button>
		<button onclick="removeFromCart('red pyjama')">Remove Red Pyjama</button>
	</div>
	<ol></ol>
<script src="script.js"></script>
</body>
</html>