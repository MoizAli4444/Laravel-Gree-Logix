<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\ApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class PayoutOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Use the API service to send a payout of the correct amount.
     * Note: The order status must be paid if the payout is successful, or remain unpaid in the event of an exception.
     *
     * @return void
     */
    public function handle(ApiService $apiService)
    {
        // TODO: Complete this method

        try {

            $merchant = $this->order->merchant;
            $email = $merchant->user->email ?? null;
            $amount = $this->order->amount;
    
            if (!$email || !$amount) {
                throw new \RuntimeException("Invalid payout details.");
            }
    
            $apiService->sendPayout($email, $amount);
    
            $this->order->update(['status' => 'paid']);
        } catch (\Exception $e) {
            Log::error("Failed to process payout for order {$this->order->id}: " . $e->getMessage());
        }
    
    }
}
