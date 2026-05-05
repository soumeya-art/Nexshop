<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Notifications\NewChatMessage;
use Illuminate\Http\Request;

class BuyerNotificationController extends Controller
{
    public function index(Request $request)
    {
        $buyer = $request->user();
        $notifications = $buyer->buyerNotifications()
            ->with(['seller', 'produit'])
            ->latest()
            ->paginate(20);

        $buyer->buyerNotifications()->where('lu', false)->update([
            'lu' => true,
            'lu_at' => now(),
        ]);

        $chatNotifications = $buyer->notifications()
            ->where('type', NewChatMessage::class)
            ->latest()
            ->limit(50)
            ->get();

        $buyer->unreadNotifications()
            ->where('type', NewChatMessage::class)
            ->update(['read_at' => now()]);

        return view('buyer.notifications.index', compact('notifications', 'chatNotifications'));
    }
}
