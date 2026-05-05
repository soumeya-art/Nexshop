<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerSubscriptionPayment;
use App\Services\SellerSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellerSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $plans = config('nexshop.seller_subscription.plans', []);
        $limit = $user->sellerFreeMonthlyLimit();
        $used = $user->sellerMonthlyOrderCount();
        $pending = SellerSubscriptionPayment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('seller.subscriptions.index', compact('user', 'plans', 'limit', 'used', 'pending'));
    }

    public function checkout(Request $request)
    {
        $plan = $request->query('plan');
        if (! in_array($plan, ['pro', 'premium'], true)) {
            return redirect()
                ->route('vendeur.abonnement.index')
                ->with('error', 'Choisissez une formule sur la page des abonnements.');
        }

        $user = $request->user();
        if ($user->hasActivePaidSubscription()) {
            return redirect()
                ->route('vendeur.abonnement.index')
                ->with('info', 'Vous avez déjà un abonnement actif. Renouvelez après la date d’expiration.');
        }

        $plans = config('nexshop.seller_subscription.plans', []);
        $amount = SellerSubscriptionService::priceForPlan($plan);
        if ($amount <= 0) {
            abort(404);
        }

        $dmoneyPortalUrl = config('nexshop.seller_subscription.dmoney_portal_login_url');
        $paymentRecipientPhone = config('nexshop.seller_subscription.payment_recipient_phone');
        $planFeatures = config('nexshop.seller_subscription.plan_features.'.$plan, []);

        return view('seller.subscriptions.checkout', compact('user', 'plan', 'plans', 'amount', 'dmoneyPortalUrl', 'paymentRecipientPhone', 'planFeatures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan' => ['required', Rule::in(['pro', 'premium'])],
            'payment_method' => ['required', Rule::in(['dmoney', 'manual'])],
            'buyer_reference' => ['nullable', 'string', 'max:191'],
            'accepted_plan_terms' => ['accepted'],
        ], [
            'accepted_plan_terms.accepted' => 'Vous devez accepter les engagements et obligations liés à cette formule.',
        ]);

        $user = $request->user();
        if ($user->hasActivePaidSubscription()) {
            return back()->with('info', 'Vous avez déjà un abonnement actif. Renouvelez après la date d’expiration.');
        }

        $amount = SellerSubscriptionService::priceForPlan($request->plan);
        if ($amount <= 0) {
            return back()->with('error', 'Plan invalide.');
        }

        SellerSubscriptionService::createPaymentRequest(
            $user,
            $request->plan,
            $request->payment_method,
            $request->buyer_reference
        );

        $tel = config('nexshop.seller_subscription.payment_recipient_phone');
        $msg = $request->payment_method === 'dmoney'
            ? 'Demande enregistrée. Transférez vers '.$tel.' via le portail D‑Money (payment.d-money.dj), puis conservez votre référence de transaction. Validation sous 24–48 h.'
            : 'Demande enregistrée. Après votre paiement en espèce (contact : '.$tel.'), la validation manuelle par l’admin activera votre plan sous 24–48 h.';

        return redirect()
            ->route('vendeur.abonnement.index')
            ->with('success', $msg);
    }
}
