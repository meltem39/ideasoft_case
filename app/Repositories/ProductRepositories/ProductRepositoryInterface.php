<?php

namespace App\Repositories\ProductRepositories;

interface ProductRepositoryInterface {

    public function listProducts();

    public function stockControl($product_id, $quantity);

    public static function productDetail($id);
}
