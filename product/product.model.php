<?php

class ProductModel {
    private $id;
    private $libelle;
    private $quantite;
    private $subcategory_id;
    private $description;
    private $price;
    private $subcategory_name;

    public function __construct(?int $id=null,?string $libelle=null,?int $quantite=null,?int $subcategory_id=null, ?string $description=null,?int $price=null) {
        if($id!=null)
            $this->id = $id;
        if($libelle!=null){
            $this->libelle = $libelle;
            $this->quantite = $quantite;
            $this->subcategory_id = $subcategory_id;
            $this->description = $description;
            $this->price = $price;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function getSubcategoryId() {
        return $this->subcategory_id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getSubcategoryName() {
        return $this->subcategory_name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

    public function setSubcategoryId($subcategory_id) {
        $this->subcategory_id = $subcategory_id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setSubcategoryName($subcategory_name) {
        $this->subcategory_name = $subcategory_name;
    }
}
?>