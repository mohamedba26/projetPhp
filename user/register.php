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
        if(isset($_POST["email"])){
            $userController=new UserController();
            $userModel=new UserModel(isset($_POST["email"]),isset($_POST["password"]));
            $result=$userController->login($userModel);
            $userModel=$userController->getUserByToken();
            if($userModel->getRole()==0){

            }
        }
    ?>
</body>
</html>