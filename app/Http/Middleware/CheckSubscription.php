<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Allow if user is not a referent (employees don't need subscriptions)
        if (!$user || !$user->hasRole('referent')) {
            return $next($request);
        }

        // Allow access to pricing-related routes
        $allowedRoutes = ['pricing', 'pricing.checkout', 'pricing.success', 'pricing.cancel'];
        if ($request->route() && in_array($request->route()->getName(), $allowedRoutes)) {
            return $next($request);
        }

        // Check if user has an active subscription or is on trial
        if (!$user->subscribed('default') && !$user->onTrial('default')) {
            // If subscription status is not active, redirect to pricing
            if (!in_array($user->subscription_status, ['active', 'trialing'])) {
                return redirect()->route('pricing')
                    ->with('message', 'Vous devez avoir un abonnement actif pour accéder à cette fonctionnalité.');
            }
        }

        return $next($request);
    }
}
