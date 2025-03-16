<?php
require_once "../category/category.controller.php";
$categoryController = new CategoryController();
if ($categoryController->connectionSuccess()) {
    $categories = $categoryController->getCategories();
    foreach ($categories as $category)
        echo '<li><a class="dropdown-item" href="#">' . $category->getCategoryName() . '</a></li>';
}
