<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require_once "product.controller.php";
    $productController = new ProductController();
    if (isset($_POST["add"])) {
        $product = new ProductModel(null, $_POST["libelle"], $_POST["quantite"], $_POST["subcategory_id"], $_POST["description"], $_POST["price"]);
        if($productController->connectionSuccess()){
            require_once "../image/image.controller.php";
            $productController->addProduct($product);
            $productId=$productController->getConnection()->lastInsertId();
            $imageController = new ImageController($productController->getConnection());
            foreach ($_FILES["files"]["name"] as $key => $file){
                $image = new ImageModel($productId,$_FILES["files"]["tmp_name"][$key]);
                $imageController->addImage($image);
            }
        }
        else {
            echo "check your internet connection";
            exit();
        }
    } elseif (isset($_POST["update"])) {
        $product = new ProductModel($_POST["id"], $_POST["libelle"], $_POST["quantite"], $_POST["subcategory_id"], $_POST["description"], $_POST["price"]);
        if ($productController->connectionSuccess())
            $productController->updateProduct($product);
        else {
            echo "check your internet connection";
            exit();
        }
    } elseif (isset($_POST["delete"])) {
        if ($productController->connectionSuccess())
            $productController->deleteProduct($_POST["id"]);
        else {
            echo "check your internet connection";
            exit();
        }
    }
    if($productController->connectionSuccess()) {
        $products = $productController->getProducts();
    ?>
        <a href="productForm.php">
            <button>add</button>
        </a>
        <table>
            <tr>
                <th>libelle</th>
                <th>price</th>
                <th>quantite</th>
                <th>description</th>
                <th>subcategory</th>
                <th>actions</th>
            </tr>
            <?php
            foreach ($products as $product) {
            ?>
                <tr>
                    <td><?php echo $product->getLibelle() ?></td>
                    <td><?php echo $product->getPrice() ?></td>
                    <td><?php echo $product->getQuantite() ?></td>
                    <td><?php echo $product->getDescription() ?></td>
                    <td><?php echo $product->getSubcategoryName() ?></td>
                    <td>
                        <a href="productForm.php?id=<?php echo $product->getId() ?>">
                            <button>update</button>
                        </a>
                        <form action="productList.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $product->getId() ?>" />
                            <input type="submit" value="delete" name="delete" />
                        </form>
                    </td>
                </tr>
        <?php
            }
            echo "</table>";
        }
        else{
            echo "check your internet connection";
            exit();
        }
        ?>
        <script src="../scripts/script.js"></script>
</body>
</html>