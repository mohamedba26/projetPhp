<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_COOKIE["auth_token"])) {
        header("location:../product/ClientProductList.php");
        exit();
    } else {
        require_once "../user/user.controller.php";
        require_once "../user/user.model.php";
        require_once "../navbars/adminNavBar.php";
        require_once "../category/category.controller.php";
        require_once "subcategory.controller.php";
        require_once "subcategory.model.php";
        $userController = new UserController();
        $userModel = $userController->getUserByToken();
        if ($userModel->getRole() == 1) {
            header("location:../product/ClientProductList.php");
            exit();
        }
    }
    if (isset($_GET["id"])) {
        $subCategoryController = new SubCategoryController();
        if ($subCategoryController->connectionSuccess()) {
            $subCategory = $subCategoryController->getSubCategoryById($_GET["id"]);
        } else {
            echo "check your internet connection";
            exit();
        }
        $formType = "update";
    } else {
        $subCategory = new SubCategoryModel(null, "", 0);
        $formType = "add";
    }
    $categoryController = new CategoryController();
    if ($categoryController->connectionSuccess()) {
    ?>
        <form action='subcategoryList.php' method='post'>
            <?php if (isset($_GET["id"])) { ?>
                <input value="<?php echo $subCategory->getId(); ?>" type="hidden" name="id" />
            <?php } ?>
            <input type='text' name='category_name' value='<?php echo $subCategory->getSubCategoryName(); ?>' required /><br />
            <select name='category_id'>
                <?php
                $categories = $categoryController->getCategories();
                foreach ($categories as $category) {
                    $selected = $category->getId() == $subCategory->getCategoryId() ? 'selected' : '';
                    echo "<option value='{$category->getId()}' $selected>{$category->getCategoryName()}</option>";
                }
                ?>
            </select><br />
            <input type='submit' value="<?php echo $formType ?>" name="<?php echo $formType ?>" />
        </form>
    <?php
    } else
        echo "check your internet connection";
    ?>
</body>

</html>