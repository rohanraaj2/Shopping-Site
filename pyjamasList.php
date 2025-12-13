<?php
// Load and parse the JSON file
$jsonFile = 'productdata.json';
$jsonData = file_get_contents($jsonFile);
$productsData = json_decode($jsonData, true);

// Get pyjamas data
$pyjamas = $productsData['pyjamas'];
?>

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
	
	<ol id="productList">
		<?php foreach ($pyjamas as $pyjama): ?>
		<li id='Pyjamas<?php echo $pyjama['pid']; ?>'>
			<img src="<?php echo htmlspecialchars($pyjama['imagepath']); ?>" 
			     alt="<?php echo htmlspecialchars($pyjama['name']); ?>" 
			     width="150">
			<p><strong><?php echo htmlspecialchars($pyjama['name']); ?></strong></p>
			<p>Price: $<?php echo htmlspecialchars($pyjama['price']); ?></p>
			<a href="product.php?pid=pyjamas-<?php echo $pyjama['pid']; ?>">View More</a>
			<input type='text' name='quantity' value=1 />
			<button onclick='addToCart(Pyjamas<?php echo $pyjama['pid']; ?>)'>Add to Cart!</button>
		</li>
		
		<br><br><br><br>
		<?php endforeach; ?>
	</ol>

	<h3>Your Shopping Cart</h3>
	<div style='margin: 20px;'>
		<p>Remove items from cart:</p>
		<?php foreach ($pyjamas as $pyjama): ?>
		<button onclick="removeFromCart('<?php echo strtolower(htmlspecialchars($pyjama['name'])); ?>')">Remove <?php echo htmlspecialchars($pyjama['name']); ?></button>
		<?php endforeach; ?>
	</div>
	<ol></ol>
<script src="script.js"></script>
</body>
</html>