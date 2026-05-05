<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerSubscriptionPayment;
use App\Services\SellerSubscriptionService;
use Illuminate\Http\Request;

class AdminSellerSubscriptionController extends Controller
{
    public function index()
    {
        $pending = SellerSubscriptionPayment::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(30);

        $recent = SellerSubscriptionPayment::with(['user', 'processor'])
            ->whereIn('status', ['paid', 'rejected'])
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.subscriptions.index', compact('pending', 'recent'));
    }

    public function approve(Request $request, SellerSubscriptionPayment $payment)
    {
        abort_unless($payment->isPending(), 404);

        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        SellerSubscriptionService::approvePayment($payment, $request->user(), $request->admin_notes);

        return back()->with('success', 'Paiement approuvé et abonnement activé (30 jours).');
    }

    public function reject(Request $request, SellerSubscriptionPayment $payment)
    {
        abort_unless($payment->isPending(), 404);

        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        SellerSubscriptionService::rejectPayment($payment, $request->user(), $request->admin_notes);

        return back()->with('success', 'Demande rejetée.');
    }
}
