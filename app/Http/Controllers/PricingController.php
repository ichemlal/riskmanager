<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    public function index()
    {
        $plans = [
            [
                'name' => 'Starter',
                'price' => env('STRIPE_PRICE_STARTER', 'price_starter'),
                'amount' => env('STRIPE_AMOUNT_STARTER', 2900), // €29.00
                'features' => [
                    'Jusqu\'à 50 employés',
                    'Campagnes illimitées',
                    'Analyses de base',
                    'Support email'
                ]
            ],
            [
                'name' => 'Professional',
                'price' => env('STRIPE_PRICE_PROFESSIONAL', 'price_professional'),
                'amount' => env('STRIPE_AMOUNT_PROFESSIONAL', 5900), // €59.00
                'features' => [
                    'Jusqu\'à 200 employés',
                    'Campagnes avancées',
                    'Analyses détaillées',
                    'Support prioritaire',
                    'Exports PDF/Excel'
                ],
                'popular' => true
            ],
            [
                'name' => 'Enterprise',
                'price' => env('STRIPE_PRICE_ENTERPRISE', 'price_enterprise'),
                'amount' => env('STRIPE_AMOUNT_ENTERPRISE', 9900), // €99.00
                'features' => [
                    'Employés illimités',
                    'Fonctionnalités avancées',
                    'API Access',
                    'Support dédié',
                    'Formation personnalisée'
                ]
            ]
        ];

        return view('pricing', compact('plans'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $priceId = $request->get('price_id');
        
        // Debug logging
        \Log::info('Checkout attempt', [
            'user_id' => $user->id,
            'price_id' => $priceId,
            'request_data' => $request->all()
        ]);
        
        // Validate price ID
        $validPrices = [
            env('STRIPE_PRICE_STARTER'),
            env('STRIPE_PRICE_PROFESSIONAL'),
            env('STRIPE_PRICE_ENTERPRISE')
        ];
        
        \Log::info('Valid prices', ['valid_prices' => $validPrices]);
        
        if (!in_array($priceId, $validPrices)) {
            \Log::error('Invalid price ID', ['price_id' => $priceId, 'valid_prices' => $validPrices]);
            return back()->withErrors(['error' => 'Plan de prix invalide']);
        }

        try {
            \Log::info('Creating Stripe checkout session');
            
            $checkout = $user->newSubscription('default', $priceId)
                ->checkout([
                    'success_url' => route('pricing.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('pricing.cancel'),
                    'customer_update' => [
                        'address' => 'auto',
                    ],
                ]);
                
            \Log::info('Checkout session created successfully');
            return $checkout;
            
        } catch (\Exception $e) {
            \Log::error('Checkout error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Erreur lors de la création de la session de paiement: ' . $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if ($sessionId) {
            // Update user subscription status
            $user = Auth::user();
            $user->subscription_status = 'active';
            $user->save();
        }

        return view('pricing.success');
    }

    public function cancel()
    {
        return view('pricing.cancel');
    }
}
