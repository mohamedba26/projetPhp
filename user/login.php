<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "user.model.php";
        require_once "user.controller.php";
        if(isset($_COOKIE["auth_token"])){
            $userController=new UserController();
            if($userController->connectionSuccess()){
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
        if(isset($_POST["email"])){
            $userController=new UserController();
            if($userController->connectionSuccess()){
                $result=$userController->login(new UserModel($_POST["email"],$_POST["password"]));
                $role=$userController->getRoleByEmail($_POST["email"]);
                if($role==0){
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
    ?>
    <form method="post">
        <input type="email" name="email" required><br/>
        <input type="password" name="password" required><br/>
        <input type="submit" value="login">
    </form>
</body>
</html>