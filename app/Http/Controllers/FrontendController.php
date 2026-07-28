<?php

namespace App\Http\Controllers;

use App\Models\AboutCompany;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BulkOrder;
use App\Models\Category;
use App\Models\MissionVision;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\NewsletterWelcomeMail;
use App\Models\BlogCategories;
use App\Models\Wishlist;
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
        $slider_data = Slider::where('slider_status', 'active')->orderBy('id', 'asc')->get();

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
            ->take(8)
            ->get();

        $blogs = Blog::where('blog_status', 'active')->latest()->take(3)->get();

        return view('frontend.index', compact('slider_data', 'categories', 'featured_products', 'latest_products', 'blogs'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  SHOP (all books with filter)
    // ─────────────────────────────────────────────────────────────────────────
    public function Shop(Request $request)
    {
        $categories = Category::active()->root()->with('recursiveChildren')->orderBy('sort_order')->get();
        $authors = Author::active()->orderBy('name')->get();
        $top_sell_product = Product::with(['authors'])
            ->active()
            // ->inStock()
            ->latest()
            ->take(5)
            ->get();

        $query = Product::with(['authors', 'categories', 'galleryImages'])->active();

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

        // Author filter
        if ($request->filled('author')) {
            $query->whereHas('authors', fn($q) => $q->where('slug', $request->author));
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

        // AJAX: return only product grid + pagination HTML
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

        $wishlistedIds = [];
        if (Auth::guard('user')->check()) {
            $wishlistedIds = Wishlist::where('user_id', Auth::guard('user')->id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('frontend.pages.shop', compact('categories', 'authors', 'products', 'top_sell_product', 'wishlistedIds'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRODUCT DETAILS
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductDetails($slug)
    {
        $product = Product::with(['authors', 'categories', 'specification', 'galleryImages', 'relatedPlatforms', 'acceptedReviews'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Related books — same category, excluding current
        $related_products = Product::with(['authors', 'galleryImages'])
            ->active()
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $product->categories->pluck('id')))
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(8)
            ->get();

        // Rating summary
        $avgRating = $product->acceptedReviews->avg('rating') ?? 0;
        $reviewCount = $product->acceptedReviews->count();

        return view('frontend.details.product_details', compact('product', 'related_products', 'avgRating', 'reviewCount'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRODUCTS BY CATEGORY
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductByCategory(Request $request, $slug)
    {
        $categoryInfo = Category::active()->where('slug', $slug)->firstOrFail();

        // all children সহ category ids
        $catIds = $categoryInfo->allDescendantIds();

        $query = Product::with(['authors', 'galleryImages'])
            ->active()
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $catIds));

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
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::active()->root()->with('children')->orderBy('sort_order')->get();

        $top_sell_product = Product::active()->inStock()->latest()->take(5)->get();

        return view('frontend.pages.product_by_category', compact('categoryInfo', 'products', 'categories', 'top_sell_product'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRODUCTS BY AUTHOR
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductByAuthor(Request $request, $slug)
    {
        $author = Author::active()->where('slug', $slug)->firstOrFail();

        $products = Product::with(['authors', 'categories', 'galleryImages'])
            ->active()
            ->whereHas('authors', fn($q) => $q->where('authors.id', $author->id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.pages.product_by_author', compact('author', 'products'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  BULK ORDER SUBMIT
    // ─────────────────────────────────────────────────────────────────────────
    // public function bulkOrderSubmit(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'name'       => 'required|string|max:150',
    //         'email'      => 'required|email|max:150',
    //         'phone'      => 'required|string|max:20',
    //         'quantity'   => 'required|integer|min:1',
    //         'message'    => 'nullable|string|max:1000',
    //     ]);

    //     BulkOrder::create($request->only(['product_id', 'name', 'email', 'phone', 'quantity', 'message']));

    //     return back()->with('success', '✅ Thank you! Your bulk order request has been submitted.');
    // }

    // ─────────────────────────────────────────────────────────────────────────
    //  CONTACT
    // ─────────────────────────────────────────────────────────────────────────
    public function Contact()
    {
        return view('frontend.pages.contact');
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  BLOG
    // ─────────────────────────────────────────────────────────────────────────
    public function Blog()
    {
        $blog_list = Blog::where('blog_status', 'active')->latest()->paginate(9);
        return view('frontend.pages.blog', compact('blog_list'));
    }

    public function BlogDetails($slug)
    {
        $blog_details = Blog::where('blog_slug', $slug)->where('blog_status', 'active')->firstOrFail();
        $recent_blogs = Blog::where('blog_status', 'active')->latest()->take(5)->get();
        $recent_products = Product::with(['authors'])
            ->active()
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.details.blog_details', compact('blog_details', 'recent_blogs', 'recent_products'));
    }

    public function BlogSearch(Request $request)
    {
        $query = $request->get('q');
        $blogs = Blog::where('blog_status', 'active')
            ->where('blog_title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->take(6)
            ->get();

        return response()->json(
            $blogs->map(
                fn($blog) => [
                    'title' => $blog->blog_title,
                    'image' => asset('upload/blog_image/' . $blog->blog_image),
                    'date' => \Carbon\Carbon::parse($blog->blog_published_date)->format('d M Y'),
                    'url' => route('blog.details', $blog->blog_slug),
                ],
            ),
        );
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
                'url' => route('product.details', $product->slug),
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
    public function quickView($id)
    {
        $product = Product::with([
            'authors',
            'galleryImages', // ProductMedia where type = 'image'
            'acceptedReviews',
        ])->findOrFail($id);

        $avgRating = $product->acceptedReviews->avg('rating') ?? 0;
        $reviewCount = $product->acceptedReviews->count();

        $discountPercent = $product->discount_price && $product->price > 0 ? round((1 - $product->discount_price / $product->price) * 100, 0) : 0;

        // Attach gallery_images key so JS can access file_path directly
        $product->setRelation('gallery_images', $product->galleryImages);

        return response()->json([
            'success' => true,
            'product' => $product, // includes gallery_images relation
            'avgRating' => round($avgRating, 1),
            'reviewCount' => $reviewCount,
            'sellingPrice' => $product->selling_price, // accessor from Product model
            'discountPercent' => $discountPercent,
            'coverImage' => $product->cover_image ? asset('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg'),
            'authorNames' => $product->authors->pluck('name')->implode(', '),
        ]);
    }

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

    // ─────────────────────────────────────────────────────────────────────────
    //  FRONTEND BLOG SUBMIT
    // ─────────────────────────────────────────────────────────────────────────
    public function BlogSubmitForm()
    {
        $blog_categories = BlogCategories::orderBy('blog_category_name')->get();
        return view('frontend.pages.blog_submit', compact('blog_categories'));
    }

    public function BlogSubmitStore(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'blog_short_description' => 'nullable|string|max:500',
            'blog_long_description' => 'required|string|min:100',
            'blog_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blog_tags' => 'nullable|string|max:500',
        ]);

        // Image save
        $manager = new ImageManager(new Driver());
        $file = $request->file('blog_image');
        $file_name = uniqid('blog_', true) . '.' . $file->getClientOriginalExtension();
        $manager
            ->read($file->getRealPath())
            ->resize(830, 553)
            ->save(public_path('upload/blog_image/') . $file_name);

        Blog::create([
            'blog_title' => $request->blog_title,
            'blog_slug' => Str::slug($request->blog_title . '-' . uniqid(), '-'),
            'blog_short_description' => $request->blog_short_description,
            'blog_long_description' => $request->blog_long_description,
            'blog_category_id' => $request->blog_category_id,
            'blog_image' => $file_name,
            'blog_tags' => $request->blog_tags,
            'blog_status' => 'pending', // admin approve করবে
            'submitted_by' => Auth::guard('user')->id(),
            'submitted_at' => now(),
            'blog_published_by' => Auth::guard('user')->id(), // placeholder
            'blog_published_date' => now(),
        ]);

        return redirect()->route('customer.dashboard')->with('success', '✅ Your blog has been submitted and is awaiting approval!');
    }

    public function BlogEditForm($id)
    {
        $blog = Blog::where('id', $id)
            ->where('submitted_by', Auth::guard('user')->id())
            ->where('blog_status', 'pending') // শুধু pending blog edit করা যাবে
            ->firstOrFail();

        $blog_categories = BlogCategories::orderBy('blog_category_name')->get();

        return view('frontend.pages.blog_edit', compact('blog', 'blog_categories'));
    }

    public function BlogEditStore(Request $request, $id)
    {
        $blog = Blog::where('id', $id)
            ->where('submitted_by', Auth::guard('user')->id())
            ->where('blog_status', 'pending')
            ->firstOrFail();

        $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'blog_short_description' => 'nullable|string|max:500',
            'blog_long_description' => 'required|string|min:100',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blog_tags' => 'nullable|string|max:500',
        ]);

        // Image update (optional)
        if ($request->hasFile('blog_image')) {
            // পুরানো image delete
            $old = public_path('upload/blog_image/' . $blog->blog_image);
            if (file_exists($old)) {
                @unlink($old);
            }

            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $file = $request->file('blog_image');
            $file_name = uniqid('blog_', true) . '.' . $file->getClientOriginalExtension();
            $manager
                ->read($file->getRealPath())
                ->resize(830, 553)
                ->save(public_path('upload/blog_image/') . $file_name);
            $blog->blog_image = $file_name;
        }

        $blog->blog_title = $request->blog_title;
        $blog->blog_slug = \Illuminate\Support\Str::slug($request->blog_title . '-' . $blog->id, '-');
        $blog->blog_short_description = $request->blog_short_description;
        $blog->blog_long_description = $request->blog_long_description;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->blog_tags = $request->blog_tags;
        $blog->submitted_at = now(); // re-submit time update
        $blog->save();

        return redirect()->route('customer.dashboard')->with('success', '✅ Blog updated successfully! Awaiting admin approval.');
    }
}
