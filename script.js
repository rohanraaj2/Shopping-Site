// Get the button
const toggleBtn = document.getElementById("toggleDarkMode");

// Add click event
toggleBtn.addEventListener("click", () => {
    // Toggle dark mode class on the body
    document.body.classList.toggle("dark-mode");

    // Optional: change button text
    if (document.body.classList.contains("dark-mode")) {
        toggleBtn.textContent = "Light Mode";
    } else {
        toggleBtn.textContent = "Dark Mode";
    }
});

var homeBtn = document.getElementById("returnHome");

if (homeBtn != null) {
    homeBtn.onclick = function() {
        window.location.href = "index.html";
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
	}else{
		usernode.style.backgroundColor='red';
		usernode.style.fontWeight='bold';
		usernode.style.color='black';
	}
	
	if (number.length >= 10){
		numbnode.style.backgroundColor='springgreen';
		numbnode.style.fontWeight='bold';
		numbnode.style.color='white';
	}else{
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
	}else{
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

var collectionList= [];

function displayList(){
	document.lastChild.lastChild.removeChild(document.lastChild.lastChild.lastChild);
	let displayList=document.createElement('ol');
	for (item of collectionList){
		let displayItem=document.createElement('li');
		displayItem.innerText=item.toString();
		displayList.appendChild(displayItem);
	}
	document.lastChild.lastChild.appendChild(displayList);
}

function addToCollection(indicator){
	purchaseObject={}
	purchaseObject.name=indicator.firstElementChild.getAttribute('alt');
	purchaseObject.quantity=indicator.lastElementChild.previousElementSibling.value;
	purchaseObject.toString= function(){return this.name+ ' quantity: '+this.quantity;};
	for (item of collectionList){
		if(item.name===purchaseObject.name){
			item.quantity=Number(item.quantity)+Number(purchaseObject.quantity);
			console.log(item.name,item.quantity);
			displayList();
			return;
		}
	
	}
	collectionList.push(purchaseObject);
	displayList();
}