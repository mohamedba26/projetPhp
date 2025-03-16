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
                $userModel=$userController->getUserByToken();
                if($userModel->getRole()==0){

                }
                else{

                }
            }
            else{
                echo "check your internet connection";
                exit();
            }
        }
        if(isset($_POST["email"])){
            $userController = new UserController();
            if($userController->register(new UserModel($_POST["email"], $_POST["password"],null, $_POST["num_tel"], $_POST["adresse"]))){
                header("location:login.php");
                exit();
            }
        }
    ?>
    <form method="post" id="form" action="register.php">
        <label for="email">email:</label>
        <input type="email" name="email" required><br>
        <label for="num_tel">Phone Number:</label>
        <input type="text" name="num_tel" required><br>
        <label for="adresse">Address:</label>
        <input type="text" name="adresse"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="verif">verify Password:</label>
        <input type="password" id="verif" required><br>
        <input type="submit" value="Register">
    </form>
    <script src="../scripts/script.js"></script>
    <script src="../scripts/register.js"></script>
</body>
</html>