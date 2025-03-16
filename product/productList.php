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



    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.html">
                Zay
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shop.html">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">
                    <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                            <div class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                        <i class="fa fa-fw fa-search text-dark mr-2"></i>
                    </a>
                    <a class="nav-icon position-relative text-decoration-none" href="#">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">7</span>
                    </a>
                    <a class="nav-icon position-relative text-decoration-none" href="#">
                        <i class="fa fa-fw fa-user text-dark mr-3"></i>
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">+99</span>
                    </a>
                </div>
            </div>

        </div>
    </nav>
    <!-- Close Header -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
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

        <!-- Start Content -->
        <div class="container py-5">
            <div class="row">

                <div class="col-lg-3">
                    <h1 class="h2 pb-4">Categories</h1>
                    <ul class="list-unstyled templatemo-accordion">
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                Gender
                                <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul class="collapse show list-unstyled pl-3">
                                <li><a class="text-decoration-none" href="#">Men</a></li>
                                <li><a class="text-decoration-none" href="#">Women</a></li>
                            </ul>
                        </li>
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                Sale
                                <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                                <li><a class="text-decoration-none" href="#">Sport</a></li>
                                <li><a class="text-decoration-none" href="#">Luxury</a></li>
                            </ul>
                        </li>
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                Product
                                <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul id="collapseThree" class="collapse list-unstyled pl-3">
                                <li><a class="text-decoration-none" href="#">Bag</a></li>
                                <li><a class="text-decoration-none" href="#">Sweather</a></li>
                                <li><a class="text-decoration-none" href="#">Sunglass</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline shop-top-menu pb-3 pt-1">
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none mr-3" href="#">All</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none" href="#">Women's</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 pb-4">
                            <div class="d-flex">
                                <select class="form-control">
                                    <option>Featured</option>
                                    <option>A to Z</option>
                                    <option>Item</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if ($productController->connectionSuccess()) {
                            $products = $productController->getProducts();
                            foreach ($products as $product) {
                                // Fetch the first image of the product
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
                                                    <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li>
                                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="far fa-eye"></i></a></li>
                                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="fas fa-cart-plus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <a href="shop-single.html" class="h3 text-decoration-none"><?php echo $product->getLibelle(); ?></a>
                                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                                <li>M/L/X/XL</li>
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

            </div>
        </div>
        <!-- End Content -->

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