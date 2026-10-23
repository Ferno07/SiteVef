<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;

class DonationController extends Controller
{
    public function index()
    {
        return view('donation.index');
    }

    public function checkout(Request $r)
    {
        $data = $r->validate([
            'amount' => 'nullable|numeric|min:1|max:100000',
            'custom_amount' => 'nullable|numeric|min:1|max:65595700',
            'amount_currency' => 'nullable|in:eur,xof',
            'projet_id' => 'nullable|integer|exists:projets,id',
        ]);
        $custom = $data['custom_amount'] ?? null;
        $centimes = $custom !== null
            ? \App\Services\Money::cents((float) $custom, $data['amount_currency'] ?? 'eur')
            : \App\Services\Money::cents((float) ($data['amount'] ?? 0));
        if ($centimes < 100 || $centimes > 10000000) {
            return back()->withInput()->with('error', 'Choisissez un montant entre 1 € et 100 000 € (ou son équivalent en FCFA).');
        }
        $project = null;
        if (! empty($data['projet_id'])) {
            $project = Projet::published()->where('dons_actifs', true)->findOrFail($data['projet_id']);
        }
        if (! config('cashier.secret')) {
            return back()->with('error', 'La collecte en ligne est momentanément indisponible.');
        }
        $donation = Donation::create(['reference' => (string) Str::uuid(), 'projet_id' => $project?->id, 'amount_centimes' => $centimes, 'currency' => 'eur', 'status' => 'pending']);
        try {
            $session = Cashier::stripe()->checkout->sessions->create([
                'payment_method_types' => ['card'], 'mode' => 'payment',
                'client_reference_id' => $donation->reference, 'metadata' => ['donation_reference' => $donation->reference],
                'line_items' => [['price_data' => ['currency' => 'eur', 'product_data' => ['name' => $project ? 'Soutenir : '.$project->titre : 'Don à Verre d’Eau Fraîche'], 'unit_amount' => $donation->amount_centimes], 'quantity' => 1]],
                'success_url' => route('donation.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $project ? route('projets.show', $project->slug).'#don' : route('donation.index'),
            ], ['idempotency_key' => $donation->reference]);
            $donation->update(['stripe_session_id' => $session->id]);

            return redirect()->away($session->url);
        } catch (\Throwable $e) {
            report($e);
            $donation->update(['status' => 'failed']);

            return back()->with('error', 'Le paiement ne peut pas être ouvert pour le moment. Veuillez réessayer.');
        }
    }

    public function webhook(Request $r)
    {
        $secret = config('cashier.webhook.secret');
        abort_unless($secret, 503);
        try {
            $event = \Stripe\Webhook::constructEvent($r->getContent(), $r->header('Stripe-Signature', ''), $secret);
        } catch (\Throwable $e) {
            return response('Signature invalide', 400);
        }
        if (! in_array($event->type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded', 'checkout.session.async_payment_failed', 'checkout.session.expired'])) {
            return response('OK');
        }
        $session = $event->data->object;
        \Illuminate\Support\Facades\DB::transaction(function () use ($session, $event) {
            $d = Donation::where('reference', $session->metadata->donation_reference ?? '')->lockForUpdate()->first();
            if (! $d || $d->status === 'confirmed') {
                return;
            }
            if ($d->stripe_session_id && $d->stripe_session_id !== $session->id) {
                return;
            }
            if ((int) $session->amount_total !== $d->amount_centimes || $session->currency !== $d->currency) {
                return;
            }
            $status = match ($event->type) {
                'checkout.session.expired' => 'expired', 'checkout.session.async_payment_failed' => 'failed',
                default => ($session->payment_status === 'paid' ? 'confirmed' : 'pending'),
            };
            $d->update(['stripe_session_id' => $session->id, 'status' => $status, 'confirmed_at' => $status === 'confirmed' ? now() : null]);
        });

        return response('OK');
    }

    public function success()
    {
        return view('donation.success');
    }
}
