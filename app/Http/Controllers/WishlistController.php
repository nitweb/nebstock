<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Toggle a product in the logged-in customer's wishlist (AJAX).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::guard('user')->id();

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success' => true, 'added' => false, 'message' => 'Removed from wishlist.']);
        }

        Wishlist::create([
            'user_id'    => $userId,
            'product_id' => $request->product_id,
        ]);

        return response()->json(['success' => true, 'added' => true, 'message' => 'Added to wishlist!']);
    }

    /**
     * Customer dashboard — My Wishlist page.
     */
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::guard('user')->id())
            ->with('product')
            ->latest()
            ->paginate(12);

        return view('frontend.customer.pages.wishlist', compact('wishlist'));
    }

    /**
     * Remove a single item from the wishlist (non-AJAX link, used on the wishlist page).
     */
    public function remove(int $id)
    {
        Wishlist::where('user_id', Auth::guard('user')->id())
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
}