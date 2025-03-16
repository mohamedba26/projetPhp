<?php
    require_once 'user.model.php';
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
            $stmt=$this->con->prepare("select salt,password from user where email=?");
            $stmt->bind_param($userModel->getEmail());
            $result=$stmt->execute();
            if($result){
                $result=$result->fetch(PDO::FETCH_ASSOC);
                if(password_verify($userModel->getPassword().$result["salt"],$result["password"])){
                    $token = bin2hex(random_bytes(32));
                    setcookie("auth_token", $token);
                    $stmt=$this->con->prepare("update user set token=? where email=?");
                    $stmt->bind_param($token,$userModel->getEmail());
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
            $stmt = $this->con->prepare("INSERT INTO user(email,password,salt,num_tel,adresse) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param($userModel->getEmail(), $hashedPassword, $salt, $userModel->getNum_tel(), $userModel->getAdresse(),1);
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
            $stmt->bind_param($userModel->getNum_tel(), $userModel->getAdresse(), $userModel->getEmail());
            try {
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function changePassword($userModel){
            $salt = bin2hex(random_bytes(32));
            $hashedPassword = password_hash($userModel->getPassword().$salt,PASSWORD_DEFAULT);
            $stmt = $this->con->prepare("update user set password=?, salt=? where email=?");
            $stmt->bind_param($hashedPassword, $salt, $userModel->getEmail());
            try {
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function getUserByToken(){
            $token = $_COOKIE["auth_token"];
            $stmt = $this->con->prepare("SELECT email,role FROM user WHERE token = '$token'");
            $stmt->bind_param($token);
            try{
                $result=$stmt->execute();
                $userModel=$result->setFetchMode(PDO::FETCH_CLASS, "UserModel");
                return $userModel;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function deconnect(){
            $token = $_COOKIE["auth_token"];
            $userModel=$this->getUserByToken($token);
            $stmt = $this->con->prepare("update user set token='' where email=?");
            $stmt->bind_param($userModel->getEmail());
            try {
                $stmt->execute();
                unset($_COOKIE["auth_token"]);
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
    }
?>