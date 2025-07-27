<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Models\User;

class WebhookController extends CashierController
{
    /**
     * Handle customer subscription created.
     */
    public function handleCustomerSubscriptionCreated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $subscription = $payload['data']['object'];
            
            // Update user with subscription details
            $user->update([
                'stripe_price_id' => $subscription['items']['data'][0]['price']['id'],
                'subscription_status' => 'active',
            ]);
        }

        return parent::handleCustomerSubscriptionCreated($payload);
    }

    /**
     * Handle customer subscription updated.
     */
    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $subscription = $payload['data']['object'];
            
            $user->update([
                'stripe_price_id' => $subscription['items']['data'][0]['price']['id'],
                'subscription_status' => $subscription['status'],
            ]);
        }

        return parent::handleCustomerSubscriptionUpdated($payload);
    }

    /**
     * Handle customer subscription deleted.
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $user->update([
                'subscription_status' => 'canceled',
            ]);
        }

        return parent::handleCustomerSubscriptionDeleted($payload);
    }

    /**
     * Handle invoice payment succeeded.
     */
    public function handleInvoicePaymentSucceeded(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $user->update([
                'subscription_status' => 'active',
            ]);
        }

        return parent::handleInvoicePaymentSucceeded($payload);
    }

    /**
     * Handle invoice payment failed.
     */
    public function handleInvoicePaymentFailed(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $user->update([
                'subscription_status' => 'past_due',
            ]);
        }

        return parent::handleInvoicePaymentFailed($payload);
    }

    /**
     * Get the user by Stripe ID.
     */
    protected function getUserByStripeId($stripeId)
    {
        return User::where('stripe_id', $stripeId)->first();
    }
}
