<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    require_once "product.model.php";
    require_once "../image/image.controller.php";
    require_once "../image/image.model.php";
    $productController = new productController();
    if ($productController->connectionSuccess()) {
        $products = $productController->getProducts();
    ?>
        <div class="row container py-5 col-lg-12" style="margin: 0 auto;">
            <?php
            if ($productController->connectionSuccess()) {
                $products = $productController->getProducts();
                foreach ($products as $product) {
                    if (!isset($imageController)) {
                        $imageController = new ImageController($productController->getConnection());
                    }
                    $image = $imageController->getFirstImageOfProduct($product->getId());
                    $file = fopen("../images/$image", 'r');
                    $data = fread($file, filesize("../images/$image"));
                    fclose($file);
            ?>
                    <div class="col-md-4">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid" src="data:image/jpg;base64,<?php echo base64_encode($data); ?>" alt="<?php echo $product->getLibelle(); ?>">
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="far fa-eye"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a href="shop-single.html" class="h3 text-decoration-none"><?php echo $product->getLibelle(); ?></a>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li class="pt-2">
                                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                    </li>
                                </ul>
                                <p class="text-center mb-0">$<?php echo $product->getPrice(); ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "check your internet connection";
                exit();
            }
            ?>
        </div>
        </div>
    <?php } ?>

</body>

</html>