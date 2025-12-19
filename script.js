// Get the button
const toggleBtn = document.getElementById("toggleDarkMode");

// Apply saved dark mode on page load
if (localStorage.getItem("darkMode") === "on") {
    document.body.classList.add("dark-mode");
    if (toggleBtn) toggleBtn.textContent = "Light Mode";
}

// Toggle dark mode on click
if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "on");
            toggleBtn.textContent = "Light Mode";
        } else {
            localStorage.setItem("darkMode", "off");
            toggleBtn.textContent = "Dark Mode";
        }
    });
}

var homeBtn = document.getElementById("returnHome");

if (homeBtn != null) {
    homeBtn.onclick = function() {
        window.location.href = "index.php";
    };
}

var productList = document.getElementById("productList");
var viewSelect = document.getElementById("viewSelect");

if (productList != null && viewSelect != null) {
    viewSelect.onchange = function() {
        var choice = viewSelect.value;
        if (choice === "horizontal") {
            productList.classList.remove("vertical-layout");
            productList.classList.add("horizontal-layout");
        } else {
            productList.classList.remove("horizontal-layout");
            productList.classList.add("vertical-layout");
        }
    };
}

function checkCredentials() {
	let usernode=document.getElementById('uName');
	let numbnode=document.getElementById('password');
	let username=usernode.value;
	let number=numbnode.value;
	if(username.length >=5 && /[A-Z]/.test(username)&& /[a-z]/.test(username)){
		usernode.style.backgroundColor='springgreen';
		usernode.style.fontWeight='bold';
		usernode.style.color='white';
	} else {
		usernode.style.backgroundColor='red';
		usernode.style.fontWeight='bold';
		usernode.style.color='black';
	}
	
	if (number.length >= 10){
		numbnode.style.backgroundColor='springgreen';
		numbnode.style.fontWeight='bold';
		numbnode.style.color='white';
	} else {
		numbnode.style.backgroundColor='red';
		numbnode.style.fontWeight='bold';
		numbnode.style.color='black';
	}
}

function checkRegister() {
	let usernode=document.getElementById('uName');
	let numbnode=document.getElementById('password');
	let cnumbnode=document.getElementById('cPassword');
	let username=usernode.value;
	let number=numbnode.value;
	let number2=cnumbnode.value;
	if(username.length >=5 && /[A-Z]/.test(username)&& /[a-z]/.test(username)){
		usernode.style.backgroundColor='springgreen';
		usernode.style.fontWeight='bold';
		usernode.style.color='white';
	}else{
		usernode.style.backgroundColor='red';
		usernode.style.fontWeight='bold';
		usernode.style.color='black';
	}
	
	if (number.length >= 10){
		numbnode.style.backgroundColor='springgreen';
		numbnode.style.fontWeight='bold';
		numbnode.style.color='white';
	} else {
		numbnode.style.backgroundColor='red';
		numbnode.style.fontWeight='bold';
		numbnode.style.color='black';
	}
	if (number === number2){
		cnumbnode.style.backgroundColor='springgreen';
		cnumbnode.style.fontWeight='bold';
		cnumbnode.style.color='white';
	}else{
		cnumbnode.style.backgroundColor='red';
		cnumbnode.style.fontWeight='bold';
		cnumbnode.style.color='black';
	}
}

var cartList= [];

function displayCart(){
	document.lastChild.lastChild.removeChild(document.lastChild.lastChild.lastChild);
	let displayList=document.createElement('ol');
	for (item of cartList){
		let displayItem=document.createElement('li');
		displayItem.innerText=item.toString();
		displayList.appendChild(displayItem);
	}
	document.lastChild.lastChild.appendChild(displayList);
}

function addToCart(indicator){
	purchaseObject={}
	purchaseObject.name=indicator.firstElementChild.getAttribute('alt');
	purchaseObject.quantity=indicator.lastElementChild.previousElementSibling.value;
	purchaseObject.toString= function(){return this.name+ ' quantity: '+this.quantity;};
	for (item of cartList){
		if(item.name===purchaseObject.name){
			item.quantity=Number(item.quantity)+Number(purchaseObject.quantity);
			console.log(item.name,item.quantity);
			displayCart();
			return;
		}
	}
	cartList.push(purchaseObject);
	displayCart();
}

function getTotalPrice(priceWOTax) {
	const final_price = priceWOTax * 1.19;
	const priceAfterTaxesLabel = document.getElementById("priceAfterTaxes");
	if (priceAfterTaxesLabel) {
		priceAfterTaxesLabel.textContent = `Price after taxes: $${final_price.toFixed(2)}`;
	}
	return final_price;
}

// Function to remove items from cart with confirmation
function removeFromCart(itemName) {
	let itemFound = false;
	let itemIndex = -1;
	
	// Search for the item in the cart
	for (let i = 0; i < cartList.length; i++) {
		if (cartList[i].name === itemName) {
			itemFound = true;
			itemIndex = i;
			break;
		}
	}
	
	if (itemFound) {
		// Create confirmation message
		const confirmMessage = `Remove ${cartList[itemIndex].name} (quantity: ${cartList[itemIndex].quantity}) from your cart?`;
		
		if (confirm(confirmMessage)) {
			// Remove the item from cart
			cartList.splice(itemIndex, 1);
			
			// Update the display
			displayCart();
			
			// Show success message
			alert(`${itemName} has been removed from your cart!`);
			console.log(`Removed ${itemName} from cart. Remaining items: ${cartList.length}`);
		} else {
			console.log('Removal cancelled by user');
		}
	} else {
		alert(`Item "${itemName}" not found in your cart.`);
		console.warn(`Attempted to remove non-existent item: ${itemName}`);
	}
}

// Function to validate and provide real-time password strength feedback
function validatePasswordStrength() {
	const passwordNode = document.getElementById('password');
	const strengthIndicator = document.getElementById('passwordStrength');
	
	if (!passwordNode) {
		console.error('Password field not found');
		return;
	}
	
	const password = passwordNode.value;
	let strength = 0;
	let strengthText = '';
	let strengthColor = '';
	
	// Check password criteria
	if (password.length >= 8) strength++;
	if (password.length >= 12) strength++;
	if (/[a-z]/.test(password)) strength++;
	if (/[A-Z]/.test(password)) strength++;
	if (/[0-9]/.test(password)) strength++;
	if (/[^a-zA-Z0-9]/.test(password)) strength++;
	
	// Determine strength level
	if (password.length === 0) {
		strengthText = '';
		strengthColor = 'transparent';
	} else if (strength <= 2) {
		strengthText = 'Weak Password';
		strengthColor = 'red';
		passwordNode.style.borderColor = 'red';
	} else if (strength <= 4) {
		strengthText = 'Medium Password';
		strengthColor = 'orange';
		passwordNode.style.borderColor = 'orange';
	} else {
		strengthText = 'Strong Password';
		strengthColor = 'green';
		passwordNode.style.borderColor = 'green';
	}
	
	// Update strength indicator if it exists
	if (strengthIndicator) {
		strengthIndicator.textContent = strengthText;
		strengthIndicator.style.color = strengthColor;
		strengthIndicator.style.fontWeight = 'bold';
		strengthIndicator.style.display = password.length > 0 ? 'block' : 'none';
	}
	
	// Add visual feedback to password field
	passwordNode.style.borderWidth = '2px';
	
	return strength;
}

// Shopping Cart Functions
function addProductToCart(productId, productName, price, category, image, pid) {
    // Try both ID and class selector for quantity input
    let quantityInput = document.getElementById('quantity-' + pid);
    if (!quantityInput) {
        quantityInput = document.querySelector('.quantity-input-' + pid);
    }
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
    
    console.log('Adding to cart:', { productId, productName, price, quantity, category, image });
    
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
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alert('Product added to cart!');
                location.reload();
            } else {
                alert('Failed to add product: ' + data.message);
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response was:', text);
            alert('Error: Invalid response from server');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while adding to cart: ' + error.message);
    });
}

function updateCartIcon(count) {
    // Reload the page to update the cart icon
    // Alternatively, you could update it dynamically with JavaScript
    location.reload();
}

function getCartCount() {
    fetch('cartHandler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=getCount'
    })
    .then(response => response.json())
    .then(data => {
        if (data.count !== undefined) {
            updateCartBadge(data.count);
        }
    })
    .catch(error => {
        console.error('Error getting cart count:', error);
    });
}

function updateCartBadge(count) {
    const badge = document.querySelector('.cart-badge');
    const emptyIcon = document.querySelector('.cart-icon-empty');
    const fullIcon = document.querySelector('.cart-icon-full');
    
    if (count > 0) {
        if (badge) badge.textContent = count;
        if (emptyIcon) emptyIcon.style.display = 'none';
        if (fullIcon) fullIcon.style.display = 'inline';
    } else {
        if (emptyIcon) emptyIcon.style.display = 'inline';
        if (fullIcon) fullIcon.style.display = 'none';
    }
}

// For single product page
function addProductToCartSingle(productId, productName, price, category, image) {
    const quantityInput = document.getElementById('quantity-single');
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
    
    console.log('Adding to cart (single):', { productId, productName, price, quantity, category, image });
    
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
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alert('Product added to cart!');
                location.reload();
            } else {
                alert('Failed to add product: ' + data.message);
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response was:', text);
            alert('Error: Invalid response from server');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while adding to cart: ' + error.message);
    });
}
