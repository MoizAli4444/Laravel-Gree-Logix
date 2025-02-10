<?php

namespace App\Services;

use App\Jobs\PayoutOrderJob;
use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MerchantService
{
    /**
     * Register a new user and associated merchant.
     * Hint: Use the password field to store the API key.
     * Hint: Be sure to set the correct user type according to the constants in the User model.
     *
     * @param array{domain: string, name: string, email: string, api_key: string} $data
     * @return Merchant
     */
    public function register(array $data): Merchant
    {

        $user = User::firstOrCreate(
            ['email' => $data['customer_email']], // Search criteria
            [
                'name' => $data['customer_name'],
                'password' => Hash::make('12345678'),
                'type' => User::TYPE_AFFILIATE,
            ]
        );

        return Merchant::create([
            'user_id' => $user->id,
            'domain' => $data['merchant_domain'],
            'display_name' => 'Store Name',
            'turn_customers_into_affiliates' => true,
            'default_commission_rate' => 0.1
        ]);
    }

    /**
     * Update the user
     *
     * @param array{domain: string, name: string, email: string, api_key: string} $data
     * @return void
     */
    public function updateMerchant(User $user, array $data)
    {
        $user->update([
            'name' => $data['name'] ?? $user->name, 
            'email' => $data['email'] ?? $user->email,
        ]);

        // Check if the user has an associated merchant
        if ($user->merchant) {
            $user->merchant->update([
                'domain' => $data['domain'] ?? $user->merchant->domain,
                'display_name' => $data['display_name'] ?? $user->merchant->display_name,
            ]);
        }
    }

    /**
     * Find a merchant by their email.
     * Hint: You'll need to look up the user first.
     *
     * @param string $email
     * @return Merchant|null
     */
    public function findMerchantByEmail(string $email): ?Merchant
    {
        // TODO: Complete this method
        $user = User::where('email', $email)->first();
        return $user ? $user->merchant : null;
    }

    /**
     * Pay out all of an affiliate's orders.
     * Hint: You'll need to dispatch the job for each unpaid order.
     *
     * @param Affiliate $affiliate
     * @return void
     */
    public function payout(Affiliate $affiliate)
    {
        // TODO: Complete this method

        $unpaidOrders = $affiliate->orders()->where('status', 'unpaid')->get();
        foreach ($unpaidOrders as $order) {
            dispatch(new PayoutOrderJob($order));
        }
    }
}
