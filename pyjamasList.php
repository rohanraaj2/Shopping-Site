<?php
session_start();
// Load and parse the JSON file
$jsonFile = 'productdata.json';
$jsonData = file_get_contents($jsonFile);
$productsData = json_decode($jsonData, true);

// Get pyjamas data
$pyjamas = $productsData['pyjamas'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Pyjamas</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
<p align="right">
    <button id="toggleDarkMode">Dark Mode</button>
    <button id="returnHome">Home</button>
</p>
<?php include 'cartIcon.php'; ?>
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
			<input type='number' class='quantity-input-<?php echo $pyjama['pid']; ?>' min='1' value='1' style='width: 60px; margin: 10px;' />
			<button onclick='addProductToCart("pyjamas-<?php echo $pyjama['pid']; ?>", "<?php echo htmlspecialchars($pyjama['name']); ?>", <?php echo $pyjama['price']; ?>, "pyjamas", "<?php echo htmlspecialchars($pyjama['imagepath']); ?>", <?php echo $pyjama['pid']; ?>)'>Add to Cart!</button>
		</li>
		
		<br><br><br><br>
		<?php endforeach; ?>
	</ol>
<script>
// Shopping Cart Function
function addProductToCart(productId, productName, price, category, image, pid) {
    let quantityInput = document.getElementById('quantity-' + pid);
    if (!quantityInput) {
        quantityInput = document.querySelector('.quantity-input-' + pid);
    }
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
    
    const formData = new URLSearchParams();
    formData.append('action', 'add');
    formData.append('productId', productId);
    formData.append('productName', productName);
    formData.append('price', price);
    formData.append('quantity', quantity);
    formData.append('category', category);
    formData.append('image', image);
    
    fetch('cartHandler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart!');
            location.reload();
        } else {
            alert('Failed to add product: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding to cart');
    });
}
</script>
<script src="script.js"></script>
</body>
</html>