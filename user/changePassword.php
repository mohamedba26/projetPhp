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
            header("location:../product/clientProductList.php");
            exit();
        }
        require_once "user.controller.php";
        require_once "user.model.php";
        $userController = new UserController();
        if (!$userController->connectionSuccess()) {
            echo "check your internet connection";
            exit();
        }
        if(isset($_POST["oldPassword"])){
            $userModel=$userController->getUserByToken();
            $userModel=new UserModel($userModel->getEmail(),$_POST["password"]);
            $result = $userController->changePassword($userModel, $_POST["oldPassword"]);
            if ($result == 2) {
                echo "old password inorrect";
            }
            elseif($result==0){
                $userModel = $userController->getUserByToken($_COOKIE["auth_token"]);
                if ($userModel->getRole() == 0) {
                    header("location:../product/productList.php");
                    exit();
                } else {
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
    <form method="POST" id="form" action="changePassword.php">        
        <label for="oldPassword">Old Password:</label>
        <input type="password" name="oldPassword" required><br>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="verifyPassword">Verify Password:</label>
        <input type="password" id="verif" name="password" required><br>
        <input type="submit" value="Update Information">
    </form>
    <script src="../scripts/register.js"></script>
</body>
</html>