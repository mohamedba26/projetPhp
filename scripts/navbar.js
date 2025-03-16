function loadCategories() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("category").innerHTML = this.responseText;
    };
    xhttp.open("GET", "categoryList.php", true);
    xhttp.send();
}

// Show categories on hover
document.getElementById("categoriesDropdown").addEventListener("mouseover", function () {
    // Load categories if not already loaded
    if (document.getElementById("category").innerHTML.trim() === "") {
        loadCategories();
    }
    document.getElementById("category").style.display = "block";
});

// Hide categories when mouse leaves
document.getElementById("categoriesDropdown").addEventListener("mouseout", function () {
    document.getElementById("category").style.display = "none";
});