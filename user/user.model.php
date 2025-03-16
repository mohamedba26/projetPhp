<?php
    class UserModel {
        private $email;
        private $password;
        private $salt;
        private $num_tel;
        private $adresse;
        private $role;

        public function __construct(?string $email=null,?string $password=null,?string $salt=null,?string $num_tel=null,?string $adresse=null) {
            if($email != null){
                $this->email = $email;
                $this->password = $password;
                $this->salt = $salt;
                $this->num_tel = $num_tel;
            }
            if($adresse != null){
                $this->adresse = $adresse;
            }
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getNum_tel() {
            return $this->num_tel;
        }

        public function getAdresse() {
            return $this->adresse;
        }

        public function getRole() {
            return $this->role;
        }

        public function getSolt(){
            return $this->salt;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function setNum_tel($num_tel) {
            $this->num_tel = $num_tel;
        }

        public function setAdresse($adresse) {
            $this->adresse = $adresse;
        }

        public function setRole($role) {
            $this->role = $role;
        }

        public function setSalt($salt){
            $this->salt = $salt;
        }
    }
?>