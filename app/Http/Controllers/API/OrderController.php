<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Repositories\OrderRepositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositories\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    private OrderRepositoryInterface $orderRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct(OrderRepositoryInterface $orderRepository,
                                ProductRepositoryInterface $productRepository
    ){
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): JsonResponse{
        $customer_id = $this->authUser()->id;
        $list = $this->orderRepository->listOrder($customer_id);
        return $this->sendResponse($list, "order list for user");
    }

    public function store(OrderStoreRequest $request){
        $data = $request->input();
        $customer_id = $this->authUser()->id;
        $stock_control = $this->productRepository->stockControl($data["product_id"], $data["quantity"]);
        if (!$stock_control){
            return $this->sendError("VALIDATION ERROR", "stock not enough");
        }

        $store = $this->orderRepository->storeProductOrder($customer_id, $data);

        return $this->sendResponse($store, "product order added.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, Request $request): JsonResponse{
        $data = $request->input();
        $customer_id = $this->authUser()->id;
        $destroy = $this->orderRepository->destroyProductOrder($customer_id, $data);

        return $this->sendResponse($destroy, "product order deleted.");
    }

}
