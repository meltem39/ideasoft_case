<?php

namespace App\Repositories\OrderRepositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\ProductRepositories\ProductRepository;
use App\Repositories\ProductRepositories\ProductRepositoryInterface;
use Illuminate\Support\Collection;

//use Your Model

/**
 * Class OrderRepository.
 */
class OrderRepository extends EloquentBaseRepository implements OrderRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */

    protected $model;
    public function __construct(Order $model)
    {
        date_default_timezone_set('Etc/GMT-3');

        $this->model = $model;

        parent::__construct($this->model);
    }


    public function orderDetail($customer_id){

        $order = $this->model->firstOrCreate([
            "customer_id" => $customer_id,
            "status" => false
        ]);

        return $order;
    }


    //****************************************************************************************************************//
    public function listOrder($customer_id): Collection{
        return Order::query()
            ->where('customer_id', $customer_id)
            ->select('id', 'total')
            ->with(['items' => function ($itemsQuery) {
                $itemsQuery->select(
                    'order_id',
                    'product_id',
                    'quantity',
                    'unit_price',
                    'total',
                );
            }])
            ->get();
    }

    public function storeProductOrder($customer_id, $data){
        $product = ProductRepository::productDetail($data["product_id"]);
        $order = $this->orderDetail($customer_id);


        $items = OrderItem::firstOrCreate([
            "order_id" => $order["id"],
            "product_id" => $data["product_id"],
            "quantity" => $data["quantity"],
            "unit_price" => $product["price"],
            "total" => $data["quantity"] * $product["price"],
        ]);

        $total_update = $order->totalUpdate();
        $stock = Product::whereId($data["product_id"])->first();
        $stock->update([
            "stock" => $stock["stock"]-$data["quantity"]
        ]);
        return $order;

    }

    public function destroyProductOrder($customer_id, $data){
        $product = ProductRepository::productDetail($data["product_id"]);
        $order = $this->model->where("customer_id", $customer_id)->where("status", false)->first();
        $items = $order->items()->where("product_id", $data["product_id"]);
        Product::whereId($data["product_id"])->update([
            "stock" => $product["stock"]+$items->first()["quantity"]
        ]);

        $items->delete();
        $total_update = $order->totalUpdate();
        return $order;
    }

}
