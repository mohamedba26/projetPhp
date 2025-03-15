<?php
    class SubCategoryModel {
        private $id;
        private $subcategory_name;
        private $category_id;
        private $category_name;

        function __construct(?int $id = null, ?string $subcategory_name = null, ?int $category_id = null) {
            if ($id !== null)
                $this->id = $id;
            if ($subcategory_name){
                $this->subcategory_name = $subcategory_name;
                $this->category_id = $category_id;
            }
        }

        public function getId() {
            return $this->id;
        }

        public function getSubCategoryName() {
            return $this->subcategory_name;
        }

        public function getCategoryId(){
            return $this->category_id;
        }

        public function getCategoryName() {
            return $this->category_name;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setSubCategoryName($subcategory_name) {
            $this->subcategory_name = $subcategory_name;
        }

        public function setCategoryId($category_id) {
            $this->category_id = $category_id;
        }

        public function setCategoryName($category_name) {
            $this->category_name = $category_name;
        }
    }
?>
