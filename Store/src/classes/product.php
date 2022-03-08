<?php
namespace App;

class product extends DB
{
    
    public $productname;
    public $productimage;
    public $salePrice;
    public $listPrice;
    public $proid ;

    public function __construct($productname, $productimage, $salePrice, $listPrice, $proid)
    {
         $this->productname = $productname;
         $this->productimage = $productimage;
         $this->salePrice = $salePrice;
        $this->listPrice = $listPrice;
        $this->proid = $proid;
    }
    public function addProduct()
    {
       
        try {
            DB::getInstance()->exec("INSERT INTO products(product_name,product_image,category_id,
            product_sale_price,product_list_price) 
                             VALUES('$this->productname','$this->productimage','$this->proid',
                             '$this->salePrice','$this->listPrice')");
            return "Product Added Sucessfully";
        } catch (\Exception $e) {
            return "Please try again later";
        }
    }
}
