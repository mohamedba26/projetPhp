<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(!isset($_COOKIE["auth_token"])){
            header("location:../product/clientProductList.php");
            exit();
        }
        require_once "user.controller.php";
        require_once "user.model.php";
        $userController=new UserController();
        if(!$userController->connectionSuccess()){
            echo "check your internet connection";
            exit();
        }
        if(isset($_POST["num_tel"])){
            $userModel=new UserModel($_POST["email"],null,null,$_POST["num_tel"],$_POST["adresse"]);
            if($userController->updateInformation($userModel)){
                $userModel=$userController->getUserByToken($_COOKIE["auth_token"]);
                if($userModel->getRole()==0){
                    header("location:../product/productList.php");
                    exit();
                }
                else{
                    header("location:../product/clientProductList.php");
                    exit();
                }
            }
            else{
                echo "check your internet connection";
                exit();
            }
        }
        $userModel=$userController->getUserByToken();
    ?>
    <form method="POST" action="changeInformation.php">
        <input type="hidden" name="email" value="<?php echo $userModel->getEmail(); ?>">
        <label for="num_tel">Phone Number:</label>
        <input type="text" name="num_tel" value="<?php echo $userModel->getNum_tel(); ?>" required>
        <br>
        <label for="adresse">Address:</label>
        <input type="text" name="adresse" value="<?php echo $userModel->getAdresse(); ?>" required>
        <br>
        <input type="hidden" name="email" value="<?php echo $userModel->getEmail(); ?>">
        <input type="submit" value="Update Information">
    </form>
</body>
</html>