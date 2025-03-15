<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_GET["id"])){
            require_once "product.controller.php";
            $productController=new ProductController();
            if($productController->connectionSuccess()){
                $product=$productController->getProductById($_GET["id"]);
                require_once "../image/image.controller.php";
                $imageController=new ImageController($productController->getConnection());
            }
            else{
                echo "check your internet connection";
                exit();
            }
            $formType="update";
        }
        else{
            require_once "product.model.php";
            $product=new ProductModel(null,"",0,0,"",0);
            $formType="add";
        }
        require_once "../category/category.controller.php";
        $categoryController=new CategoryController();
        if($categoryController->connectionSuccess()){
    ?>
    <form action="productList.php" method="post" enctype="multipart/form-data">
        <?php if(isset($_GET["id"])) { ?>
            <input value="<?php echo $product->getId() ?>" type="hidden" id="id" name="id"/>
        <?php } ?>
        <input type="text" name="libelle" value="<?php echo $product->getLibelle() ?>" required/><br/>
        <input type="number" name="price" value="<?php echo $product->getPrice() ?>" required/><br/>
        <input type="number" name="quantite" value="<?php echo $product->getQuantite() ?>" required/><br/>
        <select id="category">
            <?php
                require_once "../subcategory/subcategory.controller.php";
                $categories=$categoryController->getCategories();
                $subcategoryController=new SubCategoryController();
                if(isset($_GET["id"])) 
                    $selectedSubcategory=$subcategoryController->getSubCategoryById($product->getSubCategoryId());
                else
                    $selectedSubcategory=new SubCategoryModel(null,"",0);
                foreach($categories as $category)
                    if($category->getId()==$selectedSubcategory->getCategoryId())
                        echo "<option value='{$category->getId()}' selected>{$category->getCategoryName()}</option>";
                    else
                        echo "<option value='{$category->getId()}'>{$category->getCategoryName()}</option>";
            ?>
        </select><br/>
        <select id="subcategory" onload="loadValues()" name="subcategory_id">
        </select><br/>
        <textarea name="description" required><?php echo $product->getDescription() ?></textarea><br/>
        <input type="file" name="files[]" id="files" accept="image/*" multiple/><br/>
        <div id="images">
            <?php
                if(isset($imageController)){
                    $images=$imageController->getImagesByProductId($product->getId());
                    foreach($images as $image){
                        $file=fopen("../images/{$image->getPath()}", 'r');
                        $data = fread($file,filesize("../images/{$image->getPath()}"));
                        fclose($file);
            ?>
                <div style="position: relative; display: inline-block;">
                    <input type="hidden" name="oldImages[]" value="<?php echo $image->getPath() ?>"/>
                    <img src="data:image/jpg;base64,<?php echo base64_encode($data) ?>" width="100" height="100"/>
                    <span class="oldImages" style="position: absolute; top: 0; right: 0; cursor: pointer;">&times;</span>
                </div>
            <?php
                }}
            ?>
        </div>
        <input type="submit" value="<?php echo $formType ?>" name="<?php echo $formType ?>"/>
    </form>
    <?php
        }
        else
            echo "check your internet connection";
    ?>
    <script src="../scripts/script1.js"></script>
</body>
</html>