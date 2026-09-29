<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function index()
    {
        return view('donation.index');
    }

    public function checkout(Request $request)
    {
        $amount = $request->input('custom_amount') ?: $request->input('amount');
        
        if (!$amount || $amount < 1) {
            return back()->with('error', 'Veuillez choisir un montant valide.');
        }

        // Stripe Checkout for Guest (One-time payment)
        return \Illuminate\Support\Facades\Auth::user()
            ? $request->user()->checkoutCharge($amount * 100, 'Donation', 1, [
                'success_url' => route('donation.success'),
                'cancel_url' => route('donation.index'),
            ])
            : redirect(\Laravel\Cashier\Cashier::stripe()->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Don à l\'association Verre d\'eau fraîche',
                        ],
                        'unit_amount' => $amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('donation.success'),
                'cancel_url' => route('donation.index'),
            ])->url);
    }

    public function success()
    {
        return view('donation.success');
    }
}
