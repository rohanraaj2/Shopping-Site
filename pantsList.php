<?php
// Load and parse the JSON file
$jsonFile = 'productdata.json';
$jsonData = file_get_contents($jsonFile);
$productsData = json_decode($jsonData, true);

// Get pants data
$pants = $productsData['pants'];
?>

<!DOCTYPE html>
<html>
<head><title>Pants</title>

<p align="right">
    <button id="toggleDarkMode">Dark Mode</button>
    <button id="returnHome">Home</button>
</p>

<link rel="stylesheet" type="text/css" href="mystyle.css"></head>
<body>
	<h2>Here is the list of our pants</h2>
	
	<p align='center'>
	<label for="viewSelect" ><strong>View Products :</strong></label>
	<select id="viewSelect">
    <option value="vertical">Vertically</option>
    <option value="horizontal">Horizontally</option>
	</select>
	</p>
	
	<ol id="productList">
		<?php foreach ($pants as $pant): ?>
		<li id='Pants<?php echo $pant['pid']; ?>'>
			<img src="<?php echo htmlspecialchars($pant['imagepath']); ?>" 
			     alt="<?php echo htmlspecialchars($pant['name']); ?>" 
			     width="150">
			<p><strong><?php echo htmlspecialchars($pant['name']); ?></strong></p>
			<p>Price: $<?php echo htmlspecialchars($pant['price']); ?></p>
			<a href="product.php?pid=pants-<?php echo $pant['pid']; ?>">View More</a>
			<input type='text' name='quantity' value=1 />
			<button onclick='addToCart(Pants<?php echo $pant['pid']; ?>)'>Add to Cart!</button>
		</li>
		
		<br><br><br><br>
		<?php endforeach; ?>
	</ol>
	
	<h3>Your Shopping Cart</h3>
	<div style='margin: 20px;'>
		<p>Remove items from cart:</p>
		<?php foreach ($pants as $pant): ?>
		<button onclick="removeFromCart('<?php echo strtolower(htmlspecialchars($pant['name'])); ?>')">Remove <?php echo htmlspecialchars($pant['name']); ?></button>
		<?php endforeach; ?>
	</div>
	<ol></ol>
<script src="script.js"></script>
</body>
</html>
