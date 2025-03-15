<?php
    require_once "image.model.php";
    class ImageController{
        private $con;

        public function __construct($con){
            $this->con=$con;
        }

        public function connectionSuccess(){
            return $this->con->connectionSuccess();
        }

        public function addImage($imageModel){
            $result=$this->con->query("SELECT COALESCE(MAX(path), '-0') as path FROM image where product_id={$imageModel->getProductId()}");
            $maxImagePath=$result->fetch(PDO::FETCH_ASSOC)['path'];
            $imageId=(int)substr($maxImagePath,strpos($maxImagePath,"-")+1);
            $target_file = "../images/{$imageModel->getProductId()}-".($imageId+1).".jpg";
            if (!move_uploaded_file($imageModel->getPath(), $target_file)) {
                return false;
            }
            $target_file=substr($target_file,strpos($target_file,"images/")+7);
            $stmt=$this->con->prepare("insert into image values({$imageModel->getProductId()}, '$target_file')");
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function deleteImage($path){
            $stmt=$this->con->prepare("delete from image where path=$path");
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }

        public function getImagesByProductId($product_id){
            $result=$this->con->query("SELECT * FROM image where product_id=$product_id");
            $result->setFetchMode(PDO::FETCH_CLASS,"imageModel");
            return $result;
        }

        public function getFirstImageOfProduct($product_id){
            $result=$this->con->query("SELECT COALESCE(min(path),'-0') as path FROM image where product_id=$product_id");
            return $result->fetch(PDO::FETCH_ASSOC)['path'];
        }
    }
?>