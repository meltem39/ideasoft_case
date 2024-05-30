<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\DiscountRepositories\DiscountRepositoryInterface;
use App\Repositories\OrderRepositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class DiscountController extends BaseController
{
    private OrderRepositoryInterface $orderRepository;
    private DiscountRepositoryInterface $discountRepository;

    public function __construct(OrderRepositoryInterface $orderRepository,
                                DiscountRepositoryInterface $discountRepository
    ){
        $this->orderRepository = $orderRepository;
        $this->discountRepository = $discountRepository;
    }
    public function __invoke()
    {
        $customer_id = $this->authUser()->id;
        $order = $this->orderRepository->orderDetail($customer_id);
        $discount = $this->discountRepository->orderDiscount($order);
        return $this->sendResponse($discount, "discounted");
    }
}
