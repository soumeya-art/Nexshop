<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use App\Notifications\NewChatMessage;
use App\Notifications\SellerProductRejected;
use App\Notifications\SellerProductValidated;
use App\Notifications\SellerSubscriptionActivated;
use App\Notifications\SellerSubscriptionExpired;
use App\Notifications\SellerSubscriptionExpiring;
use App\Notifications\SellerSubscriptionOrderLimitReached;
use Illuminate\Http\Request;

class SellerNotificationController extends Controller
{
    /** @var array<int, class-string> */
    private static function sellerNotificationTypes(): array
    {
        return [
            NewChatMessage::class,
            SellerProductValidated::class,
            SellerProductRejected::class,
            SellerSubscriptionActivated::class,
            SellerSubscriptionExpiring::class,
            SellerSubscriptionExpired::class,
            SellerSubscriptionOrderLimitReached::class,
        ];
    }

    public function index(Request $request)
    {
        $seller = $request->user();
        abort_unless($seller->isVendeur(), 403);

        $sellerCategoryId = $seller->vendeur_categorie_id
            ?? Produit::where('vendeur_id', $seller->id)->value('categorie_id');
        $categories = Categorie::when($sellerCategoryId, function ($q) use ($sellerCategoryId) {
            $q->where('id', $sellerCategoryId);
        })->orderBy('nom')->get();

        $types = self::sellerNotificationTypes();

        $sellerNotifications = $seller->notifications()
            ->whereIn('type', $types)
            ->latest()
            ->paginate(25);

        $seller->unreadNotifications()
            ->whereIn('type', $types)
            ->update(['read_at' => now()]);

        return view('seller.seller', [
            'section' => 'notifications',
            'sellerNotifications' => $sellerNotifications,
            'categories' => $categories,
            'sellerCategoryId' => $sellerCategoryId,
            'totalSales' => 0,
            'totalOrders' => 0,
            'activeProducts' => 0,
            'avgRating' => 0,
            'recentOrders' => collect(),
            'vendeurProfil' => $seller->vendeurProfil,
            'boutique' => $seller->boutique,
            'totalReviews' => 0,
            'orders' => collect(),
        ]);
    }
}
