<?php
    require_once "../subcategory/subcategory.controller.php";
    $subcategoryController=new SubCategoryController();
    $subcategories=$subcategoryController->getSubCategories($_GET["categoryId"]);
    if(isset($_GET["productId"])){
        require_once "product.controller.php";
        $productController=new ProductController();
        $product=$productController->getProductById($_GET["productId"]);
        $selectedSubcategoryId=$product->getSubCategoryId();
    }
    else
        $selectedSubcategoryId=null;
    foreach($subcategories as $subcategory){
        if($subcategory->getId()==$selectedSubcategoryId)
            echo "<option value='{$subcategory->getId()}' selected>{$subcategory->getSubCategoryName()}</option>";
        else
            echo "<option value='{$subcategory->getId()}'>{$subcategory->getSubCategoryName()}</option>";
    }
?>