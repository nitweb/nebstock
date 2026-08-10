<?php

namespace App\Http\Controllers;

use App\Models\AboutCompany;
use App\Models\Category;
use App\Models\MissionVision;
use App\Models\Newsletter;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\NewsletterWelcomeMail;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FrontendController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  HOME
    // ─────────────────────────────────────────────────────────────────────────
    public function Index()
    {
        // Root categories with their active products (for dynamic home sections)
        $categories = Category::active()
            ->root()
            ->with([
                'recursiveChildren',
                'products' => function ($q) {
                    $q->with(['authors', 'galleryImages'])
                        ->active()
                        // ->inStock()
                        ->latest()
                        ->take(8);
                },
            ])
            ->orderBy('sort_order')
            ->get();

        // Featured products
        $featured_products = Product::with(['authors', 'categories', 'galleryImages'])
            ->active()
            ->featured()
            // ->inStock()
            ->latest()
            ->take(8)
            ->get();

        // Latest products
        $latest_products = Product::with(['authors', 'categories', 'galleryImages'])
            ->active()
            ->latest()
            ->take(28)
            ->get();

        // Site-wide stats (home section 07)
        $total_products     = Product::active()->count();
        $total_subscribers  = Newsletter::count();
        $total_downloads    = Order::count();

        // Wishlisted product ids for the logged-in customer (for heart icon state)
        $wishlistedIds = Auth::guard('user')->check()
            ? \App\Models\Wishlist::where('user_id', Auth::guard('user')->id())->pluck('product_id')->toArray()
            : [];

        return view('frontend.index', compact(
            'categories', 'featured_products', 'latest_products',
            'total_products', 'total_subscribers', 'total_downloads', 'wishlistedIds'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  SHOP (all books with filter)
    // ─────────────────────────────────────────────────────────────────────────
    public function Shop(Request $request)
    {
        $categories = Category::active()->root()->with('recursiveChildren')->orderBy('sort_order')->get();

        // Attach a product count to each category (including its descendants)
        $__attachCounts = function ($cats) use (&$__attachCounts) {
            foreach ($cats as $cat) {
                $cat->products_count = Product::active()->whereHas('categories', fn($q) => $q->whereIn('categories.id', $cat->allDescendantIds()))->count();
                if ($cat->recursiveChildren->count()) {
                    $__attachCounts($cat->recursiveChildren);
                }
            }
        };
        $__attachCounts($categories);

        $totalProductCount = Product::active()->count();

        $top_sell_product = Product::active()
            // ->inStock()
            ->latest()
            ->take(5)
            ->get();

        $query = Product::with(['categories', 'galleryImages'])->active();

        // Search filter
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Category filter (slug) — includes all descendants
        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->first();
            if ($cat) {
                $catIds = $cat->allDescendantIds(); // includes self
                $query->whereHas('categories', fn($q) => $q->whereIn('categories.id', $catIds));
            }
        }

        // Product type filter
        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        // Sort
        match ($request->get('sort', 'latest')) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        // Wishlisted product ids for the logged-in customer (for heart icon state)
        $wishlistedIds = Auth::guard('user')->check()
            ? \App\Models\Wishlist::where('user_id', Auth::guard('user')->id())->pluck('product_id')->toArray()
            : [];

        // AJAX: return only product grid + pagination HTML
        if ($request->ajax()) {
            $grid = view('frontend.pages.partials.shop_grid', compact('products', 'wishlistedIds'))->render();
            $pagination = view('frontend.pages.partials.shop_pagination', compact('products'))->render();
            return response()->json([
                'grid' => $grid,
                'pagination' => $pagination,
                'total' => $products->total(),
                'from' => $products->firstItem() ?? 0,
                'to' => $products->lastItem() ?? 0,
            ]);
        }

        return view('frontend.pages.shop', compact('categories', 'products', 'top_sell_product', 'totalProductCount', 'wishlistedIds'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRODUCTS BY CATEGORY
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductByCategory(Request $request, $slug)
    {
        $categoryInfo = Category::active()->where('slug', $slug)->firstOrFail();

        // all children সহ category ids
        $catIds = $categoryInfo->allDescendantIds();

        $query = Product::with(['authors', 'categories', 'galleryImages'])
            ->active()
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $catIds));

        // search filter
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // sort
        match ($request->get('sort', 'latest')) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        // AJAX: return only product grid + pagination HTML (same shape as Shop())
        if ($request->ajax()) {
            $grid = view('frontend.pages.partials.shop_grid', compact('products'))->render();
            $pagination = view('frontend.pages.partials.shop_pagination', compact('products'))->render();
            return response()->json([
                'grid' => $grid,
                'pagination' => $pagination,
                'total' => $products->total(),
                'from' => $products->firstItem() ?? 0,
                'to' => $products->lastItem() ?? 0,
            ]);
        }

        $categories = Category::active()->root()->with('recursiveChildren')->orderBy('sort_order')->get();

        $top_sell_product = Product::active()->inStock()->latest()->take(5)->get();

        return view('frontend.pages.product_by_category', compact('categoryInfo', 'products', 'categories', 'top_sell_product'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  CONTACT
    // ─────────────────────────────────────────────────────────────────────────
    public function Contact()
    {
        return view('frontend.pages.contact');
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  ABOUT US
    // ─────────────────────────────────────────────────────────────────────────
    public function AboutUs()
    {
        $about_company = AboutCompany::latest()->first();
        $mission_vision = MissionVision::latest()->get();
        return view('frontend.pages.about_us', compact('about_company', 'mission_vision'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX SEARCH
    // ─────────────────────────────────────────────────────────────────────────
    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        $products = Product::with(['authors'])
            ->active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%")
                    ->orWhereHas('authors', fn($a) => $a->where('name', 'like', "%{$query}%"));
            })
            ->limit(8)
            ->get();

        $mapped = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'url' => route('shop', ['q' => $product->name]),
                'coverImage' => $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg'),
                'authorNames' => $product->authors->pluck('name')->implode(', '),
                'sellingPrice' => $product->selling_price,
                'original_price' => $product->discount_price ? $product->price : null,
            ];
        });

        return response()->json(['products' => $mapped]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  QUICK VIEW (AJAX)
    // ─────────────────────────────────────────────────────────────────────────
    // ─────────────────────────────────────────────────────────────────────────
    //  STATIC PAGES
    // ─────────────────────────────────────────────────────────────────────────
    public function DataUsage()
    {
        return view('frontend.pages.data_usage');
    }
    public function RefundConditions()
    {
        return view('frontend.pages.refund_conditions');
    }
    public function ShippingPolicies()
    {
        return view('frontend.pages.shipping_policies');
    }
    public function InternationalReturns()
    {
        return view('frontend.pages.international_returns');
    }
    public function ReturnPolicy()
    {
        return view('frontend.pages.return_policy');
    }
    public function TermsConditions()
    {
        return view('frontend.pages.terms_conditions');
    }
    public function PrivacyPolicy()
    {
        return view('frontend.pages.privacy_policy');
    }

    /**
     * POST /newsletter/subscribe
     */
    public function subscribe(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|max:255',
            ],
            [
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
            ],
        );

        $email = strtolower(trim($request->email));

        // Already subscribed check
        $existing = Newsletter::where('email', $email)->first();

        if ($existing) {
            if ($existing->status === 'active') {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'This email is already subscribed to our newsletter! 🎉',
                    ],
                    422,
                );
            }

            // Re-subscribe
            $existing->update([
                'status' => 'active',
                'subscribed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Welcome back! You have been re-subscribed successfully. 📚',
            ]);
        }

        // CREATE SUBSCRIBER
        $newsletter = Newsletter::create([
            'email' => $email,
        ]);

        // SEND MAIL
        Mail::to($email)->send(new NewsletterWelcomeMail($newsletter));

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing! Stay tuned for new arrivals and exclusive picks. 📖',
        ]);
    }

    /**
     * GET /newsletter/unsubscribe/{token}
     * Email link এ click করলে unsubscribe হবে
     */
    public function unsubscribe($token)
    {
        $newsletter = Newsletter::where('unsubscribe_token', $token)->first();

        if (!$newsletter) {
            return redirect('/')->with('error', 'Invalid unsubscribe link.');
        }

        $newsletter->update(['status' => 'unsubscribed']);

        return redirect('/')->with('success', 'You have been unsubscribed from our newsletter.');
    }
}