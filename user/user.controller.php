<?php
    require_once 'user.model.php';
    require_once "../DBConnection.php";
    class UserController {
        private $con;

        public function __construct() {
            session_start();
            $this->con=DBConnection::getConnection();
        }

        public function connectionSuccess(){
            return $this->con!=null;
        }

        public function login($userModel) {
            $result=$this->con->query("select salt,password from user where email='{$userModel->getEmail()}'");
            if($result=$result->fetch(PDO::FETCH_ASSOC)){
                if(password_verify($userModel->getPassword().$result["salt"],$result["password"])){
                    $token = bin2hex(random_bytes(32));
                    setcookie("auth_token", $token);
                    $stmt=$this->con->prepare("update user set token='$token' where email='{$userModel->getEmail()}'");
                    try {
                        $stmt->execute();
                        return 0;
                    }
                    catch(Exception $e) {
                        unset($_COOKIE["auth_token"]);
                        return 3;
                    }
                }else
                    return 1;
            } 
            else {
                return 2;
            }
        }

        public function register($userModel) {
            $salt = bin2hex(random_bytes(32));
            $hashedPassword = password_hash($userModel->getPassword().$salt,PASSWORD_DEFAULT);
            $stmt = $this->con->prepare("INSERT INTO user(email,password,salt,num_tel,adresse) VALUES (?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $userModel->getEmail());
            $stmt->bindValue(2, $hashedPassword);
            $stmt->bindValue(3, $salt);
            $stmt->bindValue(4, $userModel->getNum_tel());
            $stmt->bindValue(5, $userModel->getAdresse());
            try {
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function updateInformation($userModel) {
            $stmt=$this->con->prepare("update user set num_tel=?, adresse=? where email=?");
            $stmt->bindValue(1, $userModel->getNum_tel());
            $stmt->bindValue(2, $userModel->getAdresse());
            $stmt->bindValue(3, $userModel->getEmail());
            try {
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function changePassword($userModel,$oldPassword){
            $result=$this->con->query("select salt,password from user where email='{$userModel->getEmail()}'");
            $result=$result->fetch(PDO::FETCH_ASSOC);
            if(password_verify($oldPassword.$result["salt"],$result["password"])){
                $salt = bin2hex(random_bytes(32));
                $hashedPassword = password_hash($userModel->getPassword().$salt,PASSWORD_DEFAULT);
                $stmt = $this->con->prepare("update user set password=?, salt=? where email=?");
                $stmt->bindValue(1, $hashedPassword);
                $stmt->bindValue(2, $salt);
                $stmt->bindValue(3, $userModel->getEmail());
                try {
                    $stmt->execute();
                    return 0;
                }
                catch(Exception $e) {
                    return 1;
                }
            }
            else
                return 2;
        }

        public function getUserByToken(){
            $token = $_COOKIE["auth_token"];
            $result = $this->con->query("SELECT email,num_tel,adresse,role FROM user WHERE token = '$token'");
            $result->setFetchMode(PDO::FETCH_CLASS, "UserModel");
            if($result)
                return $result->fetch();
            else
                return false;
        }

        public function logout(){
            $token = $_COOKIE["auth_token"];
            $userModel=$this->getUserByToken($token);
            $stmt = $this->con->prepare("update user set token='' where email=?");
            $stmt->bindValue(1,$userModel->getEmail());
            try {
                $stmt->execute();
                setcookie("auth_token","",time());
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function getRoleByEmail($email){
            $stmt = $this->con->prepare("SELECT role FROM user WHERE email = ?");
            $stmt->bindValue(1, $email);
            try {
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return $result['role'];
                } else {
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }
    }
?>