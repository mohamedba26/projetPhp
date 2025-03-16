function loadCategories() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("category").innerHTML = this.responseText;
        // Add hover listeners to each category after loading
        document.querySelectorAll("#category li").forEach(category => {
            category.addEventListener("mouseover", function () {
                loadSubcategories(this.getAttribute("data-category-id"));
            });
        });
    };
    xhttp.open("GET", "../navbars/categoryList.php", true);
    xhttp.send();
}

function loadSubcategories(categoryId) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("subcategory").innerHTML = this.responseText;
        document.getElementById("subcategory").style.display = "block";
    };
    xhttp.open("GET", `subcategoryList.php?categoryId=${categoryId}`, true);
    xhttp.send();
}

// Show categories on hover
document.getElementById("categoriesDropdown").addEventListener("mouseover", function () {
    if (document.getElementById("category").innerHTML.trim() === "") {
        loadCategories();
    }
    document.getElementById("category").style.display = "block";
});

// Hide categories and subcategories when mouse leaves
document.getElementById("categoriesDropdown").addEventListener("mouseout", function () {
    document.getElementById("category").style.display = "none";
    document.getElementById("subcategory").style.display = "none";
});