<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "category.model.php";
        if(isset($_GET["id"])){
            require_once "category.controller.php";
            $categoryController=new CategoryController();
            if($categoryController->connectionSuccess()){
                $category=$categoryController->getCategoryById($_GET["id"]);
            }
            else{
                echo "check your internet connection";
                exit();
            }
            $formType="update";
        }
        else{
            $category=new CategoryModel(null,"");
            $formType="add";
        }
    ?>
    <form action='categoryList.php' method='post'>
        <?php if(isset($_GET["id"])){  ?>
            <input value="<?php echo $category->getId(); ?>" type="hidden" name="id"/>
        <?php } ?>
        <input type='text' name='category_name' value='<?php echo $category->getCategoryName(); ?>' required/><br/>
        <input type='submit' value="<?php echo $formType ?>" name="<?php echo $formType ?>"/>
    </form>
</body>
</html>