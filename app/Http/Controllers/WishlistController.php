<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function userId(): ?int
    {
        return Auth::guard('user')->id();
    }

    /**
     * Cart এর মতো — logged-in হলে user_id, না হলে session_id দিয়ে query করো
     */
    private function getWishlistIdentifier(): array
    {
        if ($this->userId()) {
            return ['user_id' => $this->userId()];
        }
        return ['session_id' => session()->getId()];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Wishlist Page  (guest + logged-in)
    // ─────────────────────────────────────────────────────────────────────────

    public function Wishlist()
    {
        $wishlists = Wishlist::with('product')
            ->where($this->getWishlistIdentifier())
            ->latest()
            ->get();

        return view('frontend.pages.wishlist', compact('wishlists'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Count  (0 for guest with empty session)
    // ─────────────────────────────────────────────────────────────────────────

    public function WishlistCount()
    {
        $count = Wishlist::where($this->getWishlistIdentifier())->count();
        return response()->json(['count' => $count]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Toggle (Add / Remove)  — guest-friendly
    // ─────────────────────────────────────────────────────────────────────────

    public function WishlistToggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $identifier = $this->getWishlistIdentifier();

        $existing = Wishlist::where($identifier)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $status  = 'removed';
            $message = 'Removed from wishlist!';
        } else {
            Wishlist::create(array_merge($identifier, [
                'product_id' => $request->product_id,
                'session_id' => session()->getId(), // সবসময় store করো
            ]));
            $status  = 'added';
            $message = 'Added to wishlist!';
        }

        $count = Wishlist::where($identifier)->count();

        return response()->json([
            'status'  => $status,
            'message' => $message,
            'count'   => $count,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Remove (redirect-based, wishlist page এর form থেকে)
    // ─────────────────────────────────────────────────────────────────────────

    public function WishlistRemove($id)
    {
        Wishlist::where($this->getWishlistIdentifier())
            ->where('id', $id)
            ->firstOrFail()
            ->delete();

        return redirect()->back()->with('success', 'Removed from wishlist');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Product IDs (heart button active state এর জন্য)
    // ─────────────────────────────────────────────────────────────────────────

    public function WishlistProductIds()
    {
        $ids = Wishlist::where($this->getWishlistIdentifier())->pluck('product_id');
        return response()->json(['ids' => $ids]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX Single Remove
    // ─────────────────────────────────────────────────────────────────────────

    public function WishlistRemoveAjax($id)
    {
        Wishlist::where($this->getWishlistIdentifier())
            ->where('id', $id)
            ->firstOrFail()
            ->delete();

        $count = Wishlist::where($this->getWishlistIdentifier())->count();

        return response()->json([
            'status'  => 'removed',
            'message' => 'Removed from wishlist',
            'count'   => $count,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX Clear All
    // ─────────────────────────────────────────────────────────────────────────

    public function WishlistClear()
    {
        Wishlist::where($this->getWishlistIdentifier())->delete();

        return response()->json([
            'status'  => 'cleared',
            'message' => 'Wishlist cleared',
            'count'   => 0,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Merge guest wishlist → user wishlist (login এর পরে call করো)
    // ─────────────────────────────────────────────────────────────────────────

    public static function mergeGuestWishlist(int $userId, string $sessionId): void
    {
        $guestItems = Wishlist::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();

        foreach ($guestItems as $item) {
            // User এর wishlist এ এই product আগে থেকে আছে কিনা
            $alreadyExists = Wishlist::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->exists();

            if ($alreadyExists) {
                // Duplicate — শুধু guest টা delete করো
                $item->delete();
            } else {
                // User এ assign করো
                $item->update([
                    'user_id'    => $userId,
                    'session_id' => session()->getId(),
                ]);
            }
        }
    }
}
