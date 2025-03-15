<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "subcategory.controller.php";
        require_once "../category/category.controller.php";
        $subCategoryController=new SubCategoryController();
        if($subCategoryController->connectionSuccess()){
            if(isset($_POST["add"]))
                $subCategoryController->addSubCategory(new SubCategoryModel(null,$_POST["category_name"],$_POST["category_id"]));
            elseif(isset($_POST["update"]))
                $subCategoryController->updateSubCategory(new SubCategoryModel($_POST["id"],$_POST["category_name"],$_POST["category_id"]));
            elseif(isset($_POST["delete"]))
                $subCategoryController->deleteSubCategory($_POST["id"]);
            echo "<a href='subcategoryForm.php'><button>add subcategory</button></a>";
            if(isset($_GET["category_id"])){
                $categoryController=new CategoryController();
                $category=$categoryController->getCategoryById($_GET["category_id"]);
                echo "<h1>subcategories of {$category->getCategoryName()}</h1>";
                $subcategories=$subCategoryController->getSubCategories($_GET["category_id"]);
            }
            else
                $subcategories=$subCategoryController->getSubCategories();
            echo "<table><tr><th>subcategory</th><th>category</th><th>actions</th></tr>";
            foreach($subcategories as $subcategory){
    ?>
                <tr>
                    <td><?php echo $subcategory->getSubCategoryName() ?></td>
                    <td><?php echo $subcategory->getCategoryName() ?></td>
                    <td>
                        <a href="subcategoryForm.php?id=<?php echo $subcategory->getId() ?>">
                            <button>modify</button>
                        </a>
                        <form method='POST'>
                            <input type='hidden' name='id' value='<?php echo $subcategory->getId() ?>'/>
                            <input type='submit' name='delete' value='delete'/>
                        </form>
                    </td>
                </tr>
    <?php
            }
            echo "</table>";
        }
        else
            echo "check your internet connection";
    ?>
    <script src="../scripts/script.js"></script>
</body>
</html>