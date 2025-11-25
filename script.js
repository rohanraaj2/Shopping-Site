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


