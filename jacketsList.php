<?php
// Load and parse the JSON file
$jsonFile = 'productdata.json';
$jsonData = file_get_contents($jsonFile);
$productsData = json_decode($jsonData, true);

// Get jackets data
$jackets = $productsData['jackets'];
?>

<!DOCTYPE html>
<html>
<head><title>Jackets</title>

<p align="right">
    <button id="toggleDarkMode">Dark Mode</button>
    <button id="returnHome">Home</button>
</p>

<link rel="stylesheet" type="text/css" href="mystyle.css"></head>
<body>
	<h2>Here is the list of our jackets</h2>
	
	<p align='center'>
	<label for="viewSelect" ><strong>View Products :</strong></label>
	<select id="viewSelect">
    <option value="vertical">Vertically</option>
    <option value="horizontal">Horizontally</option>
	</select>
	</p>
	
	<ol id="productList">
		<?php foreach ($jackets as $jacket): ?>
		<li id='Jacket<?php echo $jacket['pid']; ?>'>
			<img src="<?php echo htmlspecialchars($jacket['imagepath']); ?>" 
			     alt="<?php echo htmlspecialchars($jacket['name']); ?>" 
			     width="150">
			<p><strong><?php echo htmlspecialchars($jacket['name']); ?></strong></p>
			<p>Price: $<?php echo htmlspecialchars($jacket['price']); ?></p>
			<a href="product.php?pid=jackets-<?php echo $jacket['pid']; ?>">View More</a>
			<input type='text' name='quantity' value=1 />
			<button onclick='addToCart(Jacket<?php echo $jacket['pid']; ?>)'>Add to Cart!</button>
		</li>
		
		<br><br><br><br>
		<?php endforeach; ?>
	</ol>
	
	<h3>Your Shopping Cart</h3>
	<div style='margin: 20px;'>
		<p>Remove items from cart:</p>
		<?php foreach ($jackets as $jacket): ?>
		<button onclick="removeFromCart('<?php echo strtolower(htmlspecialchars($jacket['name'])); ?>')">Remove <?php echo htmlspecialchars($jacket['name']); ?></button>
		<?php endforeach; ?>
	</div>
	<ol></ol>
<script src="script.js"></script>
</body>
</html>