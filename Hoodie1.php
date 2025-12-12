<!DOCTYPE html>
<html>

<head>
	<title>Code Hoodie</title>

	<p align="right">
		<button id="toggleDarkMode">Dark Mode</button>
		<button id="returnHome">Home</button>
	</p>

	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>

<body onload="getTotalPrice(20)">
	<h2>Code Hoodie</h2>
	<li class='product'>
		<img src="images/hoodie1.jpeg" alt="code hoodie" width="150">
		<p>Premium cotton hoodie designed for developers and tech lovers.<br>
			Features a sleek printed source-code pattern and a cozy fleece interior.<br>
			Ideal for coding marathons, study nights, or casual wear.</p>
		<p>Material: <em>100% cotton</em></p>
		<p>Produced in: <em>Greece</em></p>
		<p>Price: <strong>$20</strong></p>
		<label id="priceAfterTaxes">Price after taxes: getTotalPrice(20)</label>
		<button>Add to cart</button>
	</li>
	<script src="script.js"></script>
</body>

</html>