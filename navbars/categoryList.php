<?php
require_once "../category/category.controller.php";
require_once "../subcategory/subcategory.controller.php";
$subcategoryController = new SubCategoryController();
$categoryController = new CategoryController();
if ($categoryController->connectionSuccess()) {
    $categories = $categoryController->getCategories();
    foreach ($categories as $category) {
?>
        <li>
            <div class="dropdown-submenu"><a href="../product/ClientProductList.php?categoryId='<?php echo $category->getId(); ?>'"><?php echo $category->getCategoryName(); ?></a>
                <ul>
                    <?php
                    $subcategories = $subcategoryController->getSubCategories($category->getId());
                    foreach ($subcategories as $subcategory) {
                    ?>
                        <li><a href="../product/ClientProductList.php?subCategoryId='<?php echo $subcategory->getId(); ?>'"><?php echo $subcategory->getSubCategoryName() ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

        </li>
<?php
    }
}
