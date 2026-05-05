<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerFollowController extends Controller
{
    public function toggle(Request $request, User $seller)
    {
        $buyer = $request->user();

        if ($buyer->id === $seller->id) {
            return back()->with('error', 'Vous ne pouvez pas vous suivre vous-meme.');
        }

        $exists = $buyer->followedSellers()->where('seller_id', $seller->id)->exists();

        if ($exists) {
            $buyer->followedSellers()->detach($seller->id);

            return back()->with('success', 'Vous ne suivez plus ce vendeur.');
        }

        $buyer->followedSellers()->attach($seller->id);

        return back()->with('success', 'Vous suivez maintenant ce vendeur.');
    }
}
