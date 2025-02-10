<?php

namespace App\Http\Controllers;

use App\Services\AffiliateService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Pass the necessary data to the process order method
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // TODO: Complete this method
        $data = $request->validate([
            'order_id' => 'required|string|numeric',
            'subtotal_price' => 'required|numeric',
            'merchant_domain' => 'required|string|unique:merchants,domain',
            'discount_code' => 'nullable|string',
            'customer_email' => 'required|email',
            'customer_name' => 'required|string',
        ]);

        $result = $this->orderService->processOrder($data);

        if ($result !== 'success') {
            return response()->json(['message' => $result], 400);
        }


        return response()->json(['message' => 'Order processed'], 200);
    }
}
