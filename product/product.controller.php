<?php
require_once "product.model.php";
require_once "../DBConnection.php";
class productController
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

    public function getProducts()
    {
        $result = $this->con->query("SELECT product.*,subcategory_name FROM product inner join sub_category on product.subcategory_id=sub_category.id");
        $result->setFetchMode(PDO::FETCH_CLASS, "productModel");
        return $result;
    }

    public function getProductsByCategory($categoryId)
    {
        $result = $this->con->query("SELECT product.*,subcategory_name FROM product inner join sub_category on product.subcategory_id=sub_category.id where sub_category.category_id=$categoryId");
        $result->setFetchMode(PDO::FETCH_CLASS, "productModel");
        return $result;
    }

    public function getProductsBySubCategory($subCategoryId)
    {
        $result = $this->con->query("SELECT product.*,subcategory_name FROM product inner join sub_category on product.subcategory_id=sub_category.id where sub_category.id=$subCategoryId");
        $result->setFetchMode(PDO::FETCH_CLASS, "productModel");
        return $result;
    }

    public function getProductById($id)
    {
        $result = $this->con->query("SELECT product.*,subcategory_name FROM product inner join sub_category on product.subcategory_id=sub_category.id where product.id=$id");
        $result->setFetchMode(PDO::FETCH_CLASS, "productModel");
        return $result->fetch();
    }

    public function updateProduct($productModel)
    {
        $stmt = $this->con->prepare("update product set libelle='{$productModel->getLibelle()}', price='{$productModel->getPrice()}', quantite='{$productModel->getQuantite()}', description='{$productModel->getDescription()}',subcategory_id='{$productModel->getSubCategoryId()}' where id={$productModel->getId()}");
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addProduct($productModel)
    {

        $stmt = $this->con->prepare("insert into product (libelle, price, quantite, description, subcategory_id) values('{$productModel->getLibelle()}', '{$productModel->getPrice()}', '{$productModel->getQuantite()}', '{$productModel->getDescription()}', '{$productModel->getSubCategoryId()}')");
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteProduct($id)
    {
        $stmt = $this->con->prepare("delete from product where id=$id");
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
}
