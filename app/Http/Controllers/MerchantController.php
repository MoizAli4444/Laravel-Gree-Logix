<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Order;
use App\Services\MerchantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MerchantController extends Controller
{
   
    protected MerchantService $merchantService;

    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }
    /**
     * Useful order statistics for the merchant API.
     * 
     * @param Request $request Will include a from and to date
     * @return JsonResponse Should be in the form {count: total number of orders in range, commission_owed: amount of unpaid commissions for orders with an affiliate, revenue: sum order subtotals}
     */
    public function orderStats(Request $request): JsonResponse
    {
        // TODO: Complete this method
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $orders = Order::whereBetween('created_at', [
            Carbon::parse($request->from),
            Carbon::parse($request->to)
        ])->get();

        $count = $orders->count();
        $revenue = $orders->sum('subtotal');
        $commissionOwed = $orders->whereNotNull('affiliate_id')->where('payout_status',Order::STATUS_UNPAID)->sum('subtotal') * 0.1;

        return response()->json([
            'count' => $count,
            'commission_owed' => $commissionOwed,
            'revenue' => $revenue
        ]);
    
    }
}
