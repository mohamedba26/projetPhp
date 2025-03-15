<?php
require_once 'subcategory.model.php';
require_once '../category/category.controller.php';
require_once '../DBConnection.php';
class SubCategoryController {
    private $con;

    public function __construct() {
        $this->con=DBConnection::getConnection();
    }

    public function connectionSuccess(){
        return $this->con!=null;
    }

    public function addSubCategory($subcategoryModel){
        $stmt=$this->con->prepare("insert into sub_category (subcategory_name, category_id) values('{$subcategoryModel->getSubCategoryName()}', {$subcategoryModel->getCategoryId()})");
        try{
            $stmt->execute();
            return true;
        }
        catch(Exception $e) {
            return false;
        }
    }

    public function getSubCategories(?int $category_id = null){
        if($category_id !== null)
            $result = $this->con->query("SELECT sub_category.*,category_name FROM sub_category inner join category on category.id = sub_category.category_id WHERE category_id = $category_id");
        else 
            $result = $this->con->query("SELECT sub_category.*,category_name FROM sub_category inner join category on category.id = sub_category.category_id");
        $result->setFetchMode(PDO::FETCH_CLASS, "SubCategoryModel");
        return $result;
    }

    public function getSubCategoryById($id){
        $result = $this->con->query("SELECT * FROM sub_category where id=$id");
        $result->setFetchMode(PDO::FETCH_CLASS, "SubCategoryModel");
        return $result->fetch();
    }

    public function updateSubCategory($subcategory_model){
        $stmt = $this->con->prepare("update sub_category set subcategory_name='{$subcategory_model->getSubCategoryName()}', category_id={$subcategory_model->getCategoryId()} where id={$subcategory_model->getId()}");
        try{
            $stmt->execute();
            return true;
        }
        catch(Exception $e) {
            return false;
        }
    }

    public function deleteSubCategory($id){
        $stmt = $this->con->prepare("delete from sub_category where id=$id");
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