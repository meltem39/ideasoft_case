<?php

namespace App\Repositories\DiscountRepositories;

use App\Models\Discount;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\ProductRepositories\ProductRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class DiscountRepository.
 */
class DiscountRepository extends EloquentBaseRepository implements DiscountRepositoryInterface
{
    protected $model;
    public function __construct(Discount $model)
    {
        date_default_timezone_set('Etc/GMT-3');

        $this->model = $model;

        parent::__construct($this->model);
    }

    public function orderDiscount($order){
        $order_items = $order->items;

        foreach ($order_items as $order_item){
            $order_item["category_id"] = ProductRepository::productDetail($order_item->product_id)->category_id;
        }

        $count = $this->countItems($order_items);

        $calculate = $this->calculateDiscount($count);


        return [
            'order_id' => $order->id,
            'discounts' => $calculate[0],
            'total_discount' => number_format(array_sum(array_column($calculate[0], "discountAmount")),2, ".", ""),
            'discounted_total' => number_format($calculate[1],2,".",""),
        ];
    }

    //****************************************************************************************************************//

    public function countItems($order_items){
        $order_items = json_decode($order_items);
        $total = array_sum(array_column($order_items, "total"));

        foreach ($order_items as $order_item){
            if ($order_item->category_id == 1){
                $case_1["detail"]["category_id"] = 1;
                $case_1["items"][] = $order_item;
            }else {
                $case_1["detail"]["category_id"] = 1;
                $case_1["items"][] = 0;
            }
            if ($order_item->category_id == 2){
                $case_2["detail"]["category_id"] = 2;
                $case_2["items"][] = $order_item;
            } else{
                $case_2["detail"]["category_id"] = 2;
                $case_2["items"][] = 0;
            }
        }

        $case_1["detail"]["item_numbers"] = array_sum(array_column($case_1["items"], "quantity"));
        $case_2["detail"]["item_numbers"] = array_sum(array_column($case_2["items"], "quantity"));
        return [$case_1, $case_2];
    }

    public function calculateDiscount($countedItems){
        $discounts = array();
        foreach ($countedItems as $countedItem){
            $discount = $this->model->where("category_id", $countedItem["detail"]["category_id"])->first();
            if (!is_null($discount)){
                $func_name = $discount["function_name"];
                $func = $this->$func_name($countedItem, $discount);
                if (!is_null($func)){
                    $discounts[] = $func;
                }
            }
        }


        $total = array_sum(array_column($discounts, "subtotal"));
        $discount = $this->model->where("category_id", NULL)->first();
        if (!is_null($discount)){
            $func_name = $discount["function_name"];
            $func = $this->$func_name($total, $discount);
            if (!is_null($func)){
                $discounts[] = $func;
                $total = $func["subtotal"];

            }

        }
        return [$discounts, $total];
    }

    public function saleProduct($countedItem, $discount){
        $sort = collect($countedItem["items"])->sortBy(["unit_price", "desc"])->values()->all();

        if ($countedItem["detail"]["item_numbers"] >= $discount["condition"]){
            $totalDiscount = number_format($sort[0]->unit_price/100*$discount["conclusion"], 2);
            $discountedTotal =  number_format(array_sum(array_column($countedItem["items"], "total"))-$totalDiscount,2, ".", "");
            return ["discountReason" => $discount["title"] ,"discountAmount" => $totalDiscount, "subtotal" => $discountedTotal];

        }
    }

    public function freeProduct($countedItem, $discount){
        $sort = collect($countedItem["items"])->sortBy(["unit_price", "desc"])->values()->all();

        if ($countedItem["detail"]["item_numbers"] > $discount["condition"]){
            $totalDiscount = number_format($sort[0]->unit_price, 2);
            $discountedTotal =  number_format(array_sum(array_column($countedItem["items"], "total"))-$totalDiscount,2, ".", "");
            return ["discountReason" => $discount["title"] ,"discountAmount" => $totalDiscount, "subtotal" => $discountedTotal];

        }
    }

    public function saleTotalProduct($total){
        $discount = $this->model->where("category_id", NULL)->first();
        if ($total >= $discount["condition"]){
            $totalDiscount = number_format($total/100*$discount["conclusion"], 2);
            $discountedTotal = number_format($total-$totalDiscount, 2, ".","");
            return ["discountReason" => $discount["title"] ,"discountAmount" => $totalDiscount, "subtotal" => $discountedTotal];
        }

    }
}
