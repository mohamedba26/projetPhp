<?php
    class CategoryModel{
        private $id;
        private $category_name;

        function __construct(?int $id=null,?string $category_name=null) {
            if($id!=null)
                $this->id = $id;
            if($category_name)
                $this->category_name = $category_name;
        }

        public function getId(){
            return $this->id;
        }

        public function getCategoryName(){
            return $this->category_name;
        }

        public function setId($id){
            $this->id=$id;
        }

        public function setCategoryName($category_name){
            return $this->category_name=$category_name;
        }
    }
?>