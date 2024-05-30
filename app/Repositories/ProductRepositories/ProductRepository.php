<?php

namespace App\Repositories\ProductRepositories;

use App\Models\Product;
use App\Repositories\EloquentBaseRepository;
//use Your Model

/**
 * Class ProductRepository.
 */
class ProductRepository extends EloquentBaseRepository implements ProductRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function __construct(Product $model)
    {
        date_default_timezone_set('Etc/GMT-3');

        $this->model = $model;
        parent::__construct($this->model);
    }

    public function listProducts()
    {
       return $this->model->where("stock", ">", 0)->get();
    }

    public function stockControl($product_id, $quantity)
    {
        $stock = $this->model->whereId($product_id)->first()->stock;
        return $stock >= $quantity;
    }

    public static function productDetail($id){
        $item = Product::whereId($id)->first();
        return $item;
    }
}
