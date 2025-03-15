<?php
    require_once "../subcategory/subcategory.controller.php";
    $subcategoryController=new SubCategoryController();
    $subcategories=$subcategoryController->getSubCategories($_GET["categoryId"]);
    foreach($subcategories as $subcategory)
        echo "<option value='{$subcategory->getId()}'>{$subcategory->getSubCategoryName()}</option>";
?>