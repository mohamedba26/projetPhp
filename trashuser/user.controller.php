<?php
require_once "user.model.php";
require_once "../DBConnection.php";
class userController
{
    private $con;

    public function __construct()
    {
        $this->con = DBConnection::getConnection();
    }

    public function connectionSuccess()
    {
        return $this->con != null;
    }

    public function getUsers()
    {
        $result = $this->con->query("SELECT * FROM user ");
        $result->setFetchMode(PDO::FETCH_CLASS, "userModel");
        return $result;
    }

    public function getUserById($id)
    {
        $result = $this->con->query("SELECT * FROM user where user.id=$id");
        $result->setFetchMode(PDO::FETCH_CLASS, "userModel");
        return $result->fetch();
    }

    public function updateUser($userModel)
    {
        $stmt = $this->con->prepare("update user set name='{$userModel->getname()}', email='{$userModel->getemail()}', password='{$userModel->getpassword()}', address='{$userModel->getaddress()}',phone='{$userModel->getphone()}, role='{$userModel->getrole()}'' where id={$userModel->getId()}");
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addUser($userModel)
    {
        $stmt = $this->con->prepare("insert into user (name, email, password, address, phone, role) values('{$userModel->getname()}', '{$userModel->getemail()}', '{$userModel->getpassword()}', '{$userModel->getaddress()}', '{$userModel->getphone()} , {$userModel->getrole()}')");
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteUser($id)
    {
        $stmt = $this->con->prepare("delete from user where id=$id");
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getConnection()
    {
        return $this->con;
    }

    public function login($email, $password)
    {
        $stmt = $this->con->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "userModel");
        $user = $stmt->fetch();
        return $user ? $user : false;
    }
}
