<?php
    require_once "category.model.php";
    require_once "../DBConnection.php";
    Class CategoryController{
        private $con;

        public function __construct(){
            $this->con=DBConnection::getConnection();
        }

        public function connectionSuccess(){
            return $this->con!=null;
        }

        public function getCategories(){
            $result=$this->con->query("SELECT * FROM category");
            $result->setFetchMode(PDO::FETCH_CLASS,"CategoryModel");
            return $result;
        }

        public function getCategoryById($id){
            $result=$this->con->query("SELECT * FROM category where id=$id");
            $result->setFetchMode(PDO::FETCH_CLASS,"CategoryModel");
            return $result->fetch();
        }

        public function updateCategory($categoryModel){
            $stmt=$this->con->prepare("update category set category_name='{$categoryModel->getCategoryName()}' where id={$categoryModel->getId()}");
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function addCategory($categoryModel){
            $stmt=$this->con->prepare("insert into category (category_name) values('{$categoryModel->getCategoryName()}')");
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function deleteCategory($id){
            $stmt=$this->con->prepare("delete from category where id=$id");
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
    }
?>