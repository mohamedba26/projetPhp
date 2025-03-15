<?php
    class imageModel{
        private $product_id;
        private $path;
        
        public function __construct(?int $product_id=null,?string $path=null){
            if($product_id!=null){
                $this->product_id=$product_id;
                $this->path=$path;
            }
        }

        public function getProductId(){
            return $this->product_id;
        }

        public function getPath(){
            return $this->path;
        }

        public function setProductId($product_id){
            $this->product_id=$product_id;
        }

        public function setPath($path){
            $this->path=$path;
        }
    }
?>