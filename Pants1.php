<!DOCTYPE html>
<html>

<head>
	<title>Khaki Pants</title>

	<p align="right">
		<button id="toggleDarkMode">Dark Mode</button>
		<button id="returnHome">Home</button>
	</p>

	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>

<body onload="getTotalPrice(40)">
	<h2>Khaki Pants</h2>
	<li class='product'>
		<img src="images/pants1.jpeg" alt="khaki pants" width="150">
		<p>Classic khaki trousers made from soft cotton twill fabric.<br>
			Tailored fit with side and back pockets for everyday comfort.<br>
			Perfect for casual outings or semi-formal occasions.</p>
		<p>Material: <em>100% cotton twill</em></p>
		<p>Produced in: <em>Pakistan</em></p>
		<p>Price: <strong>$40</strong></p>
		<label id="priceAfterTaxes">Price after taxes: getTotalPrice(40)</label>
		<button>Add to cart</button>
	</li>
	<script src="script.js"></script>
</body>

</html>