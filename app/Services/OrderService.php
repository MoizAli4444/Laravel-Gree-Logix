<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\MerchantService;

class OrderService
{

    protected AffiliateService $affiliateService;
    protected MerchantService $merchantService;

    public function __construct(AffiliateService $affiliateService,MerchantService $merchantService)
    {
        $this->affiliateService = $affiliateService;
        $this->merchantService = $merchantService;
    }

    /**
     * Process an order and log any commissions.
     * This should create a new affiliate if the customer_email is not already associated with one.
     * This method should also ignore duplicates based on order_id.
     *
     * @param  array{order_id: string, subtotal_price: float, merchant_domain: string, discount_code: string, customer_email: string, customer_name: string} $data
     * @return void
     */
    public function processOrderXXX(array $data)
    {
        // TODO: Complete this method
        // $existingOrder = Order::where('order_id', $data['order_id'])->first();
        $existingOrder = Order::where('id', $data['order_id'])->first();
        if ($existingOrder) {
            // dd("===");
            return; // Ignore duplicate order
        }
        dd($data);


        // $merchant = Merchant::where('domain', $data['merchant_domain'])->firstOrFail();
        $merchant = Merchant::where('domain', $data['merchant_domain'])->firstOrFail();
        // try {
        //     $merchant = Merchant::where('domain', $data['merchant_domain'])->firstOrFail();
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     Log::error("Merchant not found for domain: {$data['merchant_domain']}");
        //     return; // Handle the case where the merchant is missing
        // }

        $affiliate = Affiliate::where('discount_code', $data['discount_code'])->first();

        dd($merchant);
        dd("333");



        if (!$affiliate) {
            $affiliate = $this->affiliateService->register(
                $merchant,
                $data['customer_email'],
                $data['customer_name'],
                10.0
            );
        }



        // Order::create([
        //     'order_id' => $data['order_id'],
        //     'subtotal_price' => $data['subtotal_price'],
        //     'merchant_id' => $merchant->id,
        //     'affiliate_id' => $affiliate->id,
        //     'customer_email' => $data['customer_email']
        // ]);

        // <<<<<<<<<<<<<<<<<<<<<<<<

        $merchant = Merchant::create([
            'user_id' => auth()->id(),  // Assuming the logged-in user creates the merchant
            'domain' => $request->merchant_domain, // From the form
            'display_name' => 'Store Name', // Can be input from the user
            'turn_customers_into_affiliates' => true, // Default true
            'default_commission_rate' => 0.1 // Default commission
        ]);

        $affiliate = Affiliate::create([
            'user_id' => User::factory()->create()->id, // Or an existing user
            'merchant_id' => $merchant->id,
            'commission_rate' => $merchant->default_commission_rate, // Default from Merchant
            'discount_code' => $request->discount_code // From the form
        ]);

        $order = Order::create([
            'merchant_id' => $merchant->id,
            'affiliate_id' => $affiliate->id ?? null, // If no affiliate, set as null
            'subtotal' => $request->subtotal_price, // From the form
            'commission_owed' => $request->subtotal_price * ($affiliate->commission_rate ?? 0), // Calculate commission if applicable
            'payout_status' => Order::STATUS_UNPAID,
            'customer_email' => $request->customer_email,
            'discount_code' => $request->discount_code ?? null,
            'created_at' => now(),
        ]);

        // >>>>>>>>>>>>>>>>>>>>>

        Order::create([
            'merchant_id' => $merchant->id,
            'affiliate_id' => $affiliate->id ?? null, // Use null if no affiliate exists
            'subtotal' => 100.50, // Example value
            'commission_owed' => 10.00, // Example commission
            'payout_status' => Order::STATUS_UNPAID, // Using the unpaid status constant
            'customer_email' => 'customer@example.com',
            'created_at' => now(), // Current timestamp
        ]);
    }

    public function processOrder(array $data)
    {
        // TODO: Complete this method

        $existingOrder = Order::where('id', $data['order_id'])->first();
        // dd($data);

        if (!is_null($existingOrder)) {
            return 'record exists';
        }

        $user = User::first() ?? User::factory()->create();
        $data['user_id'] = $user->id; 
        

        $merchant = $this->merchantService->register($data);
        $merchant->discount_code = $data['discount_code'] ;


        $affiliate = $this->affiliateService->register(
            $merchant,
            $data['customer_email'],
            $data['customer_name'],
            $merchant->default_commission_rate
        );

        $order = Order::create([
            'merchant_id' => $merchant->id,
            'affiliate_id' => $affiliate->id ?? null, 
            'subtotal' => $data['subtotal_price'], 
            'commission_owed' => $data['subtotal_price'] * ($affiliate->commission_rate ?? 0), 
            'payout_status' => Order::STATUS_UNPAID,
            // 'customer_email' => $data['customer_email'],
            'discount_code' => $data['discount_code'] ?? null,
            'created_at' => now(),
        ]);

        return 'success';



    }
}
