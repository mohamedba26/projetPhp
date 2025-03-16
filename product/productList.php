<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zay Shop - Product Listing Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/templatemo.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">

</head>

<body>
    <?php
    require_once "product.controller.php";
    require_once "../image/image.controller.php";
    ?>
    <?php
    $productController = new ProductController();
    if (isset($_POST["add"])) {
        $product = new ProductModel(null, $_POST["libelle"], $_POST["quantite"], $_POST["subcategory_id"], $_POST["description"], $_POST["price"]);
        if ($productController->connectionSuccess()) {
            $productController->addProduct($product);
            $productId = $productController->getConnection()->lastInsertId();
            $imageController = new ImageController($productController->getConnection());
            foreach ($_FILES["files"]["name"] as $key => $file) {
                $image = new ImageModel($productId, $_FILES["files"]["tmp_name"][$key]);
                $imageController->addImage($image);
            }
        } else {
            echo "check your internet connection";
            exit();
        }
    } elseif (isset($_POST["update"])) {
        $product = new ProductModel($_POST["id"], $_POST["libelle"], $_POST["quantite"], $_POST["subcategory_id"], $_POST["description"], $_POST["price"]);
        if ($productController->connectionSuccess()) {
            $productController->updateProduct($product);
            $imageController = new ImageController($productController->getConnection());
            $productImages = $imageController->getImagesByProductId($_POST["id"]);
            foreach ($productImages as $productImage) {
                $b = false;
                $i = 0;
                while (!$b && $i < count($_POST["oldImages"])) {
                    if ($productImage->getPath() == $_POST["oldImages"][$i])
                        $b = true;
                    $i++;
                }
                if (!$b)
                    $imageController->deleteImage($productImage->getPath());
            }
            foreach ($_FILES["files"]["name"] as $key => $file) {
                $image = new ImageModel($_POST["id"], $_FILES["files"]["tmp_name"][$key]);
                $imageController->addImage($image);
            }
        } else {
            echo "check your internet connection";
            exit();
        }
    } elseif (isset($_POST["delete"])) {
        if ($productController->connectionSuccess()) {
            $imageController = new ImageController($productController->getConnection());
            $images = $imageController->getImagesByProductId($_POST["id"]);
            foreach ($images as $image)
                $imageController->deleteImage($image->getPath());
            $productController->deleteProduct($_POST["id"]);
        } else {
            echo "check your internet connection";
            exit();
        }
    }
    if ($productController->connectionSuccess()) {
        $products = $productController->getProducts();
    ?>
        <a href="productForm.php">
            <button>add</button>
        </a>
        <table>
            <tr>
                <th>id</th>
                <th>libelle</th>
                <th>image</th>
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
                    <td><?php echo $product->getId() ?></td>
                    <td><?php echo $product->getLibelle() ?></td>
                    <td>
                        <?php
                        if (!isset($imageController))
                            $imageController = new ImageController($productController->getConnection());
                        $image = $imageController->getFirstImageOfProduct($product->getId());
                        $file = fopen("../images/$image", 'r');
                        $data = fread($file, filesize("../images/$image"));
                        fclose($file);
                        ?>
                        <img src="data:image/jpg;base64,<?php echo base64_encode($data) ?>" width="100" height="100" />
                    </td>
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
        } else {
            echo "check your internet connection";
            exit();
        }
        ?>
        <script src="../scripts/script.js"></script>
</body>

</html>