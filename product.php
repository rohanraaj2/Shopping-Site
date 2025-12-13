<?php
// Load and parse the JSON file
$jsonFile = 'productdata.json';
$jsonData = file_get_contents($jsonFile);
$productsData = json_decode($jsonData, true);

// Initialize variables
$product1 = null;
$product2 = null;
$error = "";

// Function to find product by category and pid
function findProduct($data, $category, $pid) {
    if (isset($data[$category])) {
        foreach ($data[$category] as $item) {
            if ($item['pid'] == $pid) {
                return $item;
            }
        }
    }
    return null;
}

// Function to search product across all categories
function searchProductById($data, $pid) {
    $categories = ['hoodies', 'jackets', 'pants', 'pyjamas'];
    foreach ($categories as $category) {
        $product = findProduct($data, $category, $pid);
        if ($product !== null) {
            return $product;
        }
    }
    return null;
}

// Check for pid parameter (single product view)
if(isset($_GET["pid"])) {
    if(empty($_GET["pid"])) {
        $error = "No value for the parameter!";
    } else {
        $pidParts = explode('-', $_GET["pid"]);
        if (count($pidParts) == 2) {
            $category = $pidParts[0];
            $pid = $pidParts[1];
            $product1 = findProduct($productsData, $category, $pid);
            if ($product1 === null) {
                $error = "Product not found!";
            }
        } else {
            $error = "Invalid product ID format! Use format: category-pid (e.g., hoodies-1)";
        }
    }
} else {
    // Check for pid1 and pid2 parameters (two product comparison)
    if(isset($_GET["pid1"]) && isset($_GET["pid2"])) {
        if(empty($_GET["pid1"]) || empty($_GET["pid2"])) {
            $error = "One or both product IDs are empty!";
        } else {
            $pid1Parts = explode('-', $_GET["pid1"]);
            $pid2Parts = explode('-', $_GET["pid2"]);
            
            if (count($pid1Parts) == 2 && count($pid2Parts) == 2) {
                $product1 = findProduct($productsData, $pid1Parts[0], $pid1Parts[1]);
                $product2 = findProduct($productsData, $pid2Parts[0], $pid2Parts[1]);
                
                if ($product1 === null || $product2 === null) {
                    $error = "One or both products not found!";
                }
            } else {
                $error = "Invalid product ID format! Use format: category-pid (e.g., hoodies-1)";
            }
        }
    } else {
        $error = "Parameter is missing! Please provide 'pid' or both 'pid1' and 'pid2'.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product1 ? htmlspecialchars($product1['name']) : 'Product Details'; ?></title>
    
    <p align="right">
        <button id="toggleDarkMode">Dark Mode</button>
        <button id="returnHome">Home</button>
    </p>
    
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body onload="<?php if($product1) echo 'getTotalPrice(' . $product1['price'] . ')'; ?>">
    
    <?php if ($error): ?>
        <div style="color: red; padding: 20px; border: 2px solid red; margin: 20px;">
            <h2>Error</h2>
            <p><?php echo htmlspecialchars($error); ?></p>
            <p><a href="index.php">Return to Home</a></p>
        </div>
    <?php else: ?>
        
        <?php if ($product1 && $product2): ?>
            <!-- Two product comparison view -->
            <h2>Product Comparison</h2>
            <div style="display: flex; justify-content: space-around; flex-wrap: wrap;">
                
                <!-- Product 1 -->
                <div style="width: 45%; min-width: 300px; margin: 10px;">
                    <h3><?php echo htmlspecialchars($product1['name']); ?></h3>
                    <li class='product'>
                        <img src="<?php echo htmlspecialchars($product1['imagepath']); ?>" 
                             alt="<?php echo htmlspecialchars($product1['name']); ?>" 
                             width="150">
                        <p><?php echo nl2br(htmlspecialchars($product1['description'])); ?></p>
                        <p>Material: <em><?php echo htmlspecialchars($product1['material']); ?></em></p>
                        <p>Produced in: <em><?php echo htmlspecialchars($product1['country']); ?></em></p>
                        <p>Category: <em><?php echo htmlspecialchars($product1['category']); ?> - <?php echo htmlspecialchars($product1['subcategory']); ?></em></p>
                        <p>Price: <strong>$<?php echo htmlspecialchars($product1['price']); ?></strong></p>
                        <button>Add to cart</button>
                    </li>
                </div>
                
                <!-- Product 2 -->
                <div style="width: 45%; min-width: 300px; margin: 10px;">
                    <h3><?php echo htmlspecialchars($product2['name']); ?></h3>
                    <li class='product'>
                        <img src="<?php echo htmlspecialchars($product2['imagepath']); ?>" 
                             alt="<?php echo htmlspecialchars($product2['name']); ?>" 
                             width="150">
                        <p><?php echo nl2br(htmlspecialchars($product2['description'])); ?></p>
                        <p>Material: <em><?php echo htmlspecialchars($product2['material']); ?></em></p>
                        <p>Produced in: <em><?php echo htmlspecialchars($product2['country']); ?></em></p>
                        <p>Category: <em><?php echo htmlspecialchars($product2['category']); ?> - <?php echo htmlspecialchars($product2['subcategory']); ?></em></p>
                        <p>Price: <strong>$<?php echo htmlspecialchars($product2['price']); ?></strong></p>
                        <button>Add to cart</button>
                    </li>
                </div>
                
            </div>
            
        <?php elseif ($product1): ?>
            <!-- Single product view -->
            <h2><?php echo htmlspecialchars($product1['name']); ?></h2>
            <li class='product'>
                <img src="<?php echo htmlspecialchars($product1['imagepath']); ?>" 
                     alt="<?php echo htmlspecialchars($product1['name']); ?>" 
                     width="150">
                <p><?php echo nl2br(htmlspecialchars($product1['description'])); ?></p>
                <p>Material: <em><?php echo htmlspecialchars($product1['material']); ?></em></p>
                <p>Produced in: <em><?php echo htmlspecialchars($product1['country']); ?></em></p>
                <p>Category: <em><?php echo htmlspecialchars($product1['category']); ?> - <?php echo htmlspecialchars($product1['subcategory']); ?></em></p>
                <p>Price: <strong>$<?php echo htmlspecialchars($product1['price']); ?></strong></p>
                <label id="priceAfterTaxes">Price after taxes: getTotalPrice(<?php echo $product1['price']; ?>)</label>
                <button>Add to cart</button>
            </li>
        <?php endif; ?>
        
    <?php endif; ?>
    
    <script src="script.js"></script>
</body>
</html>
