<?php

namespace App\Repositories\OrderRepositories;

interface OrderRepositoryInterface{

    public function listOrder($customer_id);

    public function storeProductOrder($customer_id, $data);

    public function destroyProductOrder($customer_id, $data);

    public function orderDetail($customer_id);


}
