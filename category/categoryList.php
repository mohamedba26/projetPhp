<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "category.controller.php";
        $categoryController=new CategoryController();
        if($categoryController->connectionSuccess()){
            if(isset($_POST["update"])){
                $categoryController->updateCategory(new CategoryModel($_POST["id"],$_POST["category_name"]));
            }
            elseif(isset($_POST["add"])){
                $categoryController->addCategory(new CategoryModel(null,$_POST["category_name"]));
            }
            elseif(isset($_POST["delete"])){
                $categoryController->deleteCategory($_POST["id"]);
            }
            echo "<a href='categoryForm.php'><button>add category</button></a>";
            $categories=$categoryController->getCategories();
            echo "<table><tr><th>category</th><th>actions</th></tr>";
            foreach($categories as $category){
    ?>
                <tr>
                    <td><?php echo $category->getCategoryName() ?></td>
                    <td>
                        <a href="categoryForm.php?id=<?php echo $category->getId(); ?>">
                            <button>modify</button>
                        </a>
                        <form method='POST'>
                            <input type='hidden' name='id' value='<?php echo $category->getId() ?>'/>
                            <input type='submit' name='delete' value='delete'/>
                        </form>
                        <a href='../subcategory/subcategoryList.php?category_id=<?php echo $category->getId() ?>'>
                            <button>subcategories</button>
                        </a>
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