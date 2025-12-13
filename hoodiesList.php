<?php
// Load and parse the JSON file
$jsonFile = 'productdata.json';
$jsonData = file_get_contents($jsonFile);
$productsData = json_decode($jsonData, true);

// Get hoodies data
$hoodies = $productsData['hoodies'];
?>

<!DOCTYPE html>
<html>
<head><title>Hoodies</title>

<p align="right">
    <button id="toggleDarkMode">Dark Mode</button>
    <button id="returnHome">Home</button>
</p>

<link rel="stylesheet" type="text/css" href="mystyle.css"></head>
<body onload='displayCart()'>
	<h2>Here is the list of our hoodies</h2>
	
	<p align='center'>
	<label for="viewSelect" ><strong>View Products :</strong></label>
	<select id="viewSelect">
	<option value="vertical">Vertically</option>
    <option value="horizontal">Horizontally</option>
	</select>
	</p>
	
	<ol id="productList">
		<?php foreach ($hoodies as $hoodie): ?>
		<li id='Hoodie<?php echo $hoodie['pid']; ?>'>
			<img src="<?php echo htmlspecialchars($hoodie['imagepath']); ?>" 
			     alt="<?php echo htmlspecialchars($hoodie['name']); ?>" 
			     width="150">
			<p><strong><?php echo htmlspecialchars($hoodie['name']); ?></strong></p>
			<p>Price: $<?php echo htmlspecialchars($hoodie['price']); ?></p>
			<a href="product.php?pid=hoodies-<?php echo $hoodie['pid']; ?>">View More</a>
			<input type='text' name='quantity' value=1 />
			<button onclick='addToCart(Hoodie<?php echo $hoodie['pid']; ?>)'>Add to Cart!</button>
		</li>
		
		<br><br><br><br>
		<?php endforeach; ?>
	</ol>
	
	<hr>
	<h3>Your Shopping Cart</h3>
	<div style='margin: 20px;'>
		<p>Remove items from cart:</p>
		<?php foreach ($hoodies as $hoodie): ?>
		<button onclick="removeFromCart('<?php echo strtolower(htmlspecialchars($hoodie['name'])); ?>')">Remove <?php echo htmlspecialchars($hoodie['name']); ?></button>
		<?php endforeach; ?>
	</div>
	<ol></ol>
<script src="script.js"></script>
</body>
</html>
