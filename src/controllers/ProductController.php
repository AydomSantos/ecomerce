<?php
namespace App\Controllers; 

class ProductController {
    public function list(){
        include __DIR__ . '/../../src/views/product/list.php';
    }
}