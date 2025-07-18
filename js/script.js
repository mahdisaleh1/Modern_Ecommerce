const hamburger = document.getElementById("hamburger");
const closeBtn = document.getElementById("close-btn");
const navOverlay = document.getElementById("nav-overlay");

hamburger.addEventListener("click", ()=> {
    navOverlay.style.display = "flex";
    
});
closeBtn.addEventListener("click", () => {
    navOverlay.style.display = "none";
});


document.getElementById('search-button').addEventListener('click', () => {
    document.getElementById('search-overlay').style.display = 'block';
});

document.getElementById('close-search').addEventListener('click', () => {
    document.getElementById('search-overlay').style.display = 'none';
});

document.getElementById('search-input').addEventListener("keyup", function() {
    const query = this.value;
    if (query === "") {
        document.getElementById("product-list").innerHTML = "";
        return;  // Stop the fetch request
    }
    fetch("search.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `search=${encodeURIComponent(query)}`,
            })
            .then((response) => response.text())
            .then((data) => {
                // Update the product container with the search results
                document.getElementById("product-list").innerHTML = data;
            })
            .catch((error) => console.error("Error:", error));
});