<?php


require_once "../category/category.controller.php";
require_once "../image/image.controller.php";
$categoryController = new CategoryController();
?>
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <a
            class="navbar-brand text-success logo h1 align-self-center"
            href="index.html">
            Zay
        </a>

        <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#templatemo_main_nav"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between"
            id="templatemo_main_nav">
            <div class="flex-fill">
                <ul
                    class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../product/ClientProductList.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <div class="nav-link dropdown-toggle" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                            <ul class="dropdown-menu" id="category" aria-labelledby="categoriesDropdown" style="padding: 5px;">

                            </ul>

                        </div>

                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex mr-8">
                <!-- Search Input (Mobile) -->
                <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="inputMobileSearch"
                            placeholder="Search ..." />
                        <div class="input-group-text">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                    </div>
                </div>

                <!-- Cart Icon -->
                <a class="nav-icon position-relative text-decoration-none" href="#">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span
                        class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">7</span>
                </a>

                <!-- User Dropdown -->
                <div class="nav-icon position-relative text-decoration-none dropdown" onclick="showThings()">
                    <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    <ul class="dropdown-menu dropdown-menu-end" id="userActions" aria-labelledby="userDropdown" style="display: none;">
                        <li><a class="dropdown-item" href="#" onclick="handleChangeInfo()">Change Information</a></li>
                        <li><a class="dropdown-item" href="#" onclick="handleChangePassword()">Change Password</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="handleLogout()">Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- JavaScript for Handling Click Events -->
            <script>
                function handleChangeInfo() {
                    alert("Change Information clicked!");
                    // Add your logic here, e.g., redirect to a form page
                }

                function handleChangePassword() {
                    alert("Change Password clicked!");
                    // Add your logic here, e.g., open a modal or redirect to a password change page
                }

                function handleLogout() {
                    if (confirm("Are you sure you want to logout?")) {
                        alert("Logging out...");
                        // Add your logout logic here, e.g., redirect to the login page
                        window.location.href = "/logout"; // Example redirect
                    }
                }

                function showThings() {
                    var x = document.getElementById("userActions");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                }
            </script>
        </div>
    </div>
    <script src="../scripts/navbar.js"></script>
</nav>