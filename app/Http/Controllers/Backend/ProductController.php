<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use App\Models\RelatedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    private const IMG_W = 583;
    private const IMG_H = 583;

    // ─────────────────────────────────────────────────────────────────────────
    //  LIST
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductList()
    {
        $products = Product::latest()
            ->with(['authors', 'categories', 'variants'])
            ->get();

        return view('backend.products.list', compact('products'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  ADD FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductAdd()
    {
        $categories  = Category::active()->with('recursiveChildren')->root()->orderBy('sort_order')->get();
        $authors     = Author::active()->orderBy('name')->get();
        $productTypes = Product::productTypes();

        return view('backend.products.add', compact('categories', 'authors', 'productTypes'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductStore(Request $request)
    {
        $isAffiliate = $request->input('product_mode', 'selling') === 'affiliate';
        $isBook      = $request->input('product_type', 'book') === 'book';
        $hasVariants = in_array($request->product_type, ['clothing', 'hat']);

        // ── Validation Rules ──────────────────────────────────────────────────
        $rules = [
            'product_mode'    => 'required|in:selling,affiliate',
            'product_type'    => 'required|in:book,clothing,hat,accessory,other',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:products,slug',
            'status'          => 'required|in:active,inactive,draft',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'category_ids'    => 'required|array|min:1',
            'category_ids.*'  => 'exists:categories,id',
            'sku'             => 'nullable|string|max:100|unique:products,sku',
            // Pre-order — NEW
            'pre_order_date'  => 'nullable|date|after_or_equal:today',
            'pre_order_note'  => 'nullable|string|max:500',
            // Platforms
            'platforms.*.name'  => 'nullable|string|max:100',
            'platforms.*.url'   => 'nullable|url',
            'platforms.*.price' => 'nullable|numeric|min:0',
            // Attributes
            'attr_keys.*'    => 'nullable|string|max:100',
            'attr_values.*'  => 'nullable|string|max:255',
        ];

        if ($isAffiliate) {
            $rules['affiliate_platform'] = 'nullable|string|max:100';
            $rules['affiliate_url']      = 'required|url|max:500';
            $rules['affiliate_price']    = 'nullable|numeric|min:0';
            $rules['price']              = 'nullable|numeric|min:0';
            $rules['quantity']           = 'nullable|integer|min:0';
            $rules['stock_status']       = 'nullable|in:in_stock,out_of_stock';
        } else {
            $rules['price']              = 'required|numeric|min:0';
            $rules['discount_price']     = 'nullable|numeric|min:0|lt:price';
            $rules['quantity']           = 'required|integer|min:0';
            $rules['stock_status']       = 'required|in:in_stock,out_of_stock';
            $rules['gallery_images.*']   = 'nullable|image|mimes:jpeg,png,jpg,gif,webp';
        }

        if ($isBook && !$isAffiliate) {
            $rules['author_ids']              = 'required|array|min:1';
            $rules['author_ids.*']            = 'exists:authors,id';
            $rules['pdf_sample']              = 'nullable|file|mimes:pdf|max:51200';
            $rules['pdf_file']                = 'nullable|file|mimes:pdf|max:51200';
            $rules['spec_publisher']          = 'nullable|string|max:255';
            $rules['spec_edition']            = 'nullable|string|max:100';
            $rules['spec_pages']              = 'nullable|integer|min:1';
            $rules['spec_country']            = 'nullable|string|max:100';
            $rules['spec_language']           = 'nullable|string|max:100';
            $rules['spec_isbn']               = 'nullable|string|max:30';
            $rules['spec_publication_year']   = 'nullable|integer|min:1800|max:' . date('Y');
        } elseif ($isBook && $isAffiliate) {
            $rules['author_ids']              = 'nullable|array';
            $rules['author_ids.*']            = 'exists:authors,id';
            $rules['pdf_sample']              = 'nullable|file|mimes:pdf|max:51200';
            $rules['pdf_file']                = 'nullable|file|mimes:pdf|max:51200';
            $rules['spec_publisher']          = 'nullable|string|max:255';
            $rules['spec_edition']            = 'nullable|string|max:100';
            $rules['spec_pages']              = 'nullable|integer|min:1';
            $rules['spec_country']            = 'nullable|string|max:100';
            $rules['spec_language']           = 'nullable|string|max:100';
            $rules['spec_isbn']               = 'nullable|string|max:30';
            $rules['spec_publication_year']   = 'nullable|integer|min:1800|max:' . date('Y');
        } else {
            $rules['author_ids']   = 'nullable|array';
            $rules['author_ids.*'] = 'exists:authors,id';
        }

        if ($hasVariants && !$isAffiliate) {
            $rules['variants.*.size']      = 'nullable|string|max:50';
            $rules['variants.*.color']     = 'nullable|string|max:50';
            $rules['variants.*.color_hex'] = 'nullable|string|max:10';
            $rules['variants.*.quantity']  = 'nullable|integer|min:0';
        }

        $validator = Validator::make($request->all(), $rules, [
            'affiliate_url.required'  => 'Affiliate URL is required for affiliate products.',
            'discount_price.lt'       => 'Discount price must be less than the original price.',
            'category_ids.required'   => 'Please select at least one category.',
            'author_ids.required'     => 'Please select at least one author.',
            'pre_order_date.after_or_equal' => 'Pre-order date must be today or a future date.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $manager    = new ImageManager(new Driver());
            $attributes = $this->buildAttributes($request);

            // ── Create Product ────────────────────────────────────────────────
            $product = new Product();
            $product->product_mode     = $request->product_mode ?? 'selling';
            $product->product_type     = $request->product_type ?? 'book';
            $product->name             = $request->name;
            $product->slug             = Str::slug($request->slug, '-');
            $product->short_description = $request->short_description;
            $product->long_description  = $request->long_description;
            $product->status           = $request->status ?? 'active';
            $product->is_featured      = $request->boolean('is_featured');
            $product->sku              = $request->sku ?: null;
            $product->attributes       = $attributes ?: null;

            // ── Pre-order fields — NEW ────────────────────────────────────────
            $product->is_pre_order   = $request->boolean('is_pre_order');
            $product->pre_order_date = $product->is_pre_order ? $request->pre_order_date : null;
            $product->pre_order_note = $product->is_pre_order ? $request->pre_order_note : null;

            if ($isAffiliate) {
                $product->affiliate_platform = $request->affiliate_platform;
                $product->affiliate_url      = $request->affiliate_url;
                $product->affiliate_price    = $request->affiliate_price;
                $product->price              = $request->price ?? 0;
                $product->discount_price     = null;
                $product->quantity           = 0;
                $product->stock_status       = 'in_stock';
            } else {
                $product->price          = $request->price;
                $product->discount_price = $request->discount_price;
                $product->quantity       = $request->quantity;
                $product->stock_status   = $request->stock_status ?? 'in_stock';
                $product->affiliate_platform = null;
                $product->affiliate_url      = null;
                $product->affiliate_price    = null;
            }

            if ($request->hasFile('cover_image')) {
                $product->cover_image = $this->saveImage($manager, $request->file('cover_image'), 'product_covers');
            }

            if ($isBook) {
                if ($request->hasFile('pdf_sample')) {
                    $product->pdf_sample = $this->saveFile($request->file('pdf_sample'), 'product_pdfs', 'sample_');
                }
                if ($request->hasFile('pdf_file')) {
                    $product->pdf_file = $this->saveFile($request->file('pdf_file'), 'product_pdfs', 'full_');
                }
            }

            $product->save();

            // ── Categories ────────────────────────────────────────────────────
            $product->categories()->sync($request->category_ids);

            // ── Authors ───────────────────────────────────────────────────────
            if ($isBook && $request->filled('author_ids')) {
                $authorPivot = [];
                foreach ($request->author_ids as $index => $authorId) {
                    $authorPivot[$authorId] = ['sort_order' => $index];
                }
                $product->authors()->sync($authorPivot);
            }

            // ── Gallery ───────────────────────────────────────────────────────
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $file) {
                    ProductMedia::create([
                        'product_id' => $product->id,
                        'type'       => 'image',
                        'file_path'  => $this->saveImage($manager, $file, 'product_gallery'),
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            // ── Book Specification ────────────────────────────────────────────
            if ($isBook) {
                ProductSpecification::create([
                    'product_id'       => $product->id,
                    'publisher'        => $request->spec_publisher,
                    'edition'          => $request->spec_edition,
                    'number_of_pages'  => $request->spec_pages,
                    'country'          => $request->spec_country,
                    'language'         => $request->spec_language ?? 'Bengali',
                    'isbn'             => $request->spec_isbn,
                    'publication_year' => $request->spec_publication_year,
                ]);
            }

            // ── Platforms ─────────────────────────────────────────────────────
            if ($request->filled('platforms')) {
                foreach ($request->platforms as $platform) {
                    if (!empty($platform['name']) && !empty($platform['url'])) {
                        RelatedProduct::create([
                            'product_id'     => $product->id,
                            'platform_name'  => $platform['name'],
                            'platform_url'   => $platform['url'],
                            'platform_price' => $platform['price'] ?? null,
                        ]);
                    }
                }
            }

            // ── Variants ──────────────────────────────────────────────────────
            if (!$isAffiliate && $hasVariants && $request->filled('variants')) {
                foreach ($request->variants as $idx => $v) {
                    if (empty($v['size']) && empty($v['color'])) {
                        continue;
                    }
                    ProductVariant::create([
                        'product_id'   => $product->id,
                        'size'         => $v['size'] ?? null,
                        'color'        => $v['color'] ?? null,
                        'color_hex'    => $v['color_hex'] ?? null,
                        'quantity'     => $v['quantity'] ?? 0,
                        'stock_status' => ($v['quantity'] ?? 0) > 0 ? 'in_stock' : 'out_of_stock',
                        'sort_order'   => $idx,
                        'is_active'    => true,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('backend.products.list')
                ->with(['message' => 'Product created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Store Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to create product. ' . $e->getMessage(), 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  EDIT FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductEdit(int $id)
    {
        $product = Product::with([
            'categories',
            'authors',
            'specification',
            'galleryImages',
            'relatedPlatforms',
            'variants',
        ])->findOrFail($id);

        $categories     = Category::active()->with('recursiveChildren')->root()->orderBy('sort_order')->get();
        $authors        = Author::active()->orderBy('name')->get();
        $productTypes   = Product::productTypes();
        $selectedCats   = $product->categories->pluck('id')->toArray();
        $selectedAuthors = $product->authors->pluck('id')->toArray();

        return view('backend.products.edit', compact(
            'product',
            'categories',
            'authors',
            'productTypes',
            'selectedCats',
            'selectedAuthors'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductUpdate(Request $request)
    {
        $isAffiliate = $request->input('product_mode', 'selling') === 'affiliate';
        $isBook      = $request->input('product_type', 'book') === 'book';
        $hasVariants = in_array($request->product_type, ['clothing', 'hat']);

        $rules = [
            'id'              => 'required|exists:products,id',
            'product_mode'    => 'required|in:selling,affiliate',
            'product_type'    => 'required|in:book,clothing,hat,accessory,other',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:products,slug,' . $request->id,
            'status'          => 'required|in:active,inactive,draft',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'category_ids'    => 'required|array|min:1',
            'category_ids.*'  => 'exists:categories,id',
            'sku'             => 'nullable|string|max:100|unique:products,sku,' . $request->id,
            // Pre-order — NEW
            'pre_order_date'  => 'nullable|date',
            'pre_order_note'  => 'nullable|string|max:500',
            // Platforms
            'platforms.*.name'  => 'nullable|string|max:100',
            'platforms.*.url'   => 'nullable|url',
            'platforms.*.price' => 'nullable|numeric|min:0',
        ];

        if ($isAffiliate) {
            $rules['affiliate_platform'] = 'nullable|string|max:100';
            $rules['affiliate_url']      = 'required|url|max:500';
            $rules['affiliate_price']    = 'nullable|numeric|min:0';
            $rules['price']              = 'nullable|numeric|min:0';
            $rules['quantity']           = 'nullable|integer|min:0';
            $rules['stock_status']       = 'nullable|in:in_stock,out_of_stock';
        } else {
            $rules['price']            = 'required|numeric|min:0';
            $rules['discount_price']   = 'nullable|numeric|min:0|lt:price';
            $rules['quantity']         = 'required|integer|min:0';
            $rules['stock_status']     = 'required|in:in_stock,out_of_stock';
            $rules['gallery_images.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp';
        }

        if ($isBook && !$isAffiliate) {
            $rules['author_ids']            = 'required|array|min:1';
            $rules['author_ids.*']          = 'exists:authors,id';
            $rules['pdf_sample']            = 'nullable|file|mimes:pdf|max:51200';
            $rules['pdf_file']              = 'nullable|file|mimes:pdf|max:51200';
            $rules['spec_publisher']        = 'nullable|string|max:255';
            $rules['spec_edition']          = 'nullable|string|max:100';
            $rules['spec_pages']            = 'nullable|integer|min:1';
            $rules['spec_country']          = 'nullable|string|max:100';
            $rules['spec_language']         = 'nullable|string|max:100';
            $rules['spec_isbn']             = 'nullable|string|max:30';
            $rules['spec_publication_year'] = 'nullable|integer|min:1800|max:' . date('Y');
        } else {
            $rules['author_ids']   = 'nullable|array';
            $rules['author_ids.*'] = 'exists:authors,id';
        }

        $validator = Validator::make($request->all(), $rules, [
            'affiliate_url.required' => 'Affiliate URL is required for affiliate products.',
            'discount_price.lt'      => 'Discount price must be less than the original price.',
            'category_ids.required'  => 'Please select at least one category.',
            'author_ids.required'    => 'Please select at least one author.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $manager    = new ImageManager(new Driver());
            $product    = Product::findOrFail($request->id);
            $attributes = $this->buildAttributes($request);

            $product->product_mode      = $request->product_mode;
            $product->product_type      = $request->product_type;
            $product->name              = $request->name;
            $product->slug              = Str::slug($request->slug, '-');
            $product->short_description = $request->short_description;
            $product->long_description  = $request->long_description;
            $product->status            = $request->status ?? 'active';
            $product->is_featured       = $request->boolean('is_featured');
            $product->sku               = $request->sku ?: null;
            $product->attributes        = $attributes ?: null;

            // ── Pre-order fields — NEW ────────────────────────────────────────
            $product->is_pre_order   = $request->boolean('is_pre_order');
            $product->pre_order_date = $product->is_pre_order ? $request->pre_order_date : null;
            $product->pre_order_note = $product->is_pre_order ? $request->pre_order_note : null;

            if ($isAffiliate) {
                $product->affiliate_platform = $request->affiliate_platform;
                $product->affiliate_url      = $request->affiliate_url;
                $product->affiliate_price    = $request->affiliate_price;
                $product->price              = $request->price ?? 0;
                $product->discount_price     = null;
                $product->quantity           = 0;
                $product->stock_status       = 'in_stock';
            } else {
                $product->price              = $request->price;
                $product->discount_price     = $request->discount_price;
                $product->quantity           = $request->quantity;
                $product->stock_status       = $request->stock_status ?? 'in_stock';
                $product->affiliate_platform = null;
                $product->affiliate_url      = null;
                $product->affiliate_price    = null;
            }

            if ($request->hasFile('cover_image')) {
                $this->deleteFile('product_covers', $product->cover_image);
                $product->cover_image = $this->saveImage($manager, $request->file('cover_image'), 'product_covers');
            }

            if ($isBook) {
                if ($request->hasFile('pdf_sample')) {
                    $this->deleteFile('product_pdfs', $product->pdf_sample);
                    $product->pdf_sample = $this->saveFile($request->file('pdf_sample'), 'product_pdfs', 'sample_');
                }
                if ($request->hasFile('pdf_file')) {
                    $this->deleteFile('product_pdfs', $product->pdf_file);
                    $product->pdf_file = $this->saveFile($request->file('pdf_file'), 'product_pdfs', 'full_');
                }
            }

            $product->save();

            $product->categories()->sync($request->category_ids);

            if ($isBook && $request->filled('author_ids')) {
                $authorPivot = [];
                foreach ($request->author_ids as $index => $authorId) {
                    $authorPivot[$authorId] = ['sort_order' => $index];
                }
                $product->authors()->sync($authorPivot);
            } elseif (!$isBook) {
                $product->authors()->detach();
            }

            if ($request->hasFile('gallery_images')) {
                $lastOrder = $product->galleryImages()->max('sort_order') ?? 0;
                foreach ($request->file('gallery_images') as $index => $file) {
                    ProductMedia::create([
                        'product_id' => $product->id,
                        'type'       => 'image',
                        'file_path'  => $this->saveImage($manager, $file, 'product_gallery'),
                        'is_primary' => false,
                        'sort_order' => $lastOrder + $index + 1,
                    ]);
                }
            }

            if ($isBook) {
                $product->specification()->updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'publisher'        => $request->spec_publisher,
                        'edition'          => $request->spec_edition,
                        'number_of_pages'  => $request->spec_pages,
                        'country'          => $request->spec_country,
                        'language'         => $request->spec_language ?? 'Bengali',
                        'isbn'             => $request->spec_isbn,
                        'publication_year' => $request->spec_publication_year,
                    ],
                );
            }

            $product->relatedPlatforms()->delete();
            if ($request->filled('platforms')) {
                foreach ($request->platforms as $platform) {
                    if (!empty($platform['name']) && !empty($platform['url'])) {
                        RelatedProduct::create([
                            'product_id'     => $product->id,
                            'platform_name'  => $platform['name'],
                            'platform_url'   => $platform['url'],
                            'platform_price' => $platform['price'] ?? null,
                        ]);
                    }
                }
            }

            if (!$isAffiliate && $hasVariants) {
                $product->allVariants()->delete();
                if ($request->filled('variants')) {
                    foreach ($request->variants as $idx => $v) {
                        if (empty($v['size']) && empty($v['color'])) {
                            continue;
                        }
                        ProductVariant::create([
                            'product_id'   => $product->id,
                            'size'         => $v['size'] ?? null,
                            'color'        => $v['color'] ?? null,
                            'color_hex'    => $v['color_hex'] ?? null,
                            'quantity'     => $v['quantity'] ?? 0,
                            'stock_status' => ($v['quantity'] ?? 0) > 0 ? 'in_stock' : 'out_of_stock',
                            'sort_order'   => $idx,
                            'is_active'    => true,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->back()
                ->with(['message' => 'Product updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to update product.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DELETE
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductDelete(int $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::with(['galleryImages', 'relatedPlatforms', 'specification'])->findOrFail($id);

            $this->deleteFile('product_covers', $product->cover_image);
            $this->deleteFile('product_pdfs', $product->pdf_sample);
            $this->deleteFile('product_pdfs', $product->pdf_file);

            foreach ($product->galleryImages as $media) {
                $this->deleteFile('product_gallery', $media->file_path);
                $media->delete();
            }

            $product->delete();

            DB::commit();

            return redirect()
                ->route('backend.products.list')
                ->with(['message' => 'Product deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Delete Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to delete product.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  GALLERY MANAGEMENT
    // ─────────────────────────────────────────────────────────────────────────
    public function GalleryImageUpdate(Request $request, int $id)
    {
        $media = ProductMedia::findOrFail($id);
        $request->validate(['gallery_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp']);

        try {
            $manager = new ImageManager(new Driver());
            $this->deleteFile('product_gallery', $media->file_path);
            $media->file_path = $this->saveImage($manager, $request->file('gallery_image'), 'product_gallery');
            $media->save();

            return redirect()->back()->with(['message' => 'Gallery image updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Gallery Update Error: ' . $e->getMessage());
            return redirect()->back()->with(['message' => 'Failed to update image.', 'alert-type' => 'error']);
        }
    }

    public function GalleryImageDelete(int $id)
    {
        $media = ProductMedia::findOrFail($id);

        try {
            $this->deleteFile('product_gallery', $media->file_path);
            $media->delete();

            return redirect()->back()->with(['message' => 'Gallery image deleted!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Gallery Delete Error: ' . $e->getMessage());
            return redirect()->back()->with(['message' => 'Failed to delete image.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────
    private function saveImage(ImageManager $manager, $file, string $folder): string
    {
        $fileName = uniqid($folder . '_', true) . '.' . $file->getClientOriginalExtension();
        $img = $manager->read($file->getRealPath());
        $img->resize(self::IMG_W, self::IMG_H);
        $img->save(public_path("upload/{$folder}/{$fileName}"));
        return $fileName;
    }

    private function saveFile($file, string $folder, string $prefix = ''): string
    {
        $fileName = uniqid($prefix, true) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("upload/{$folder}"), $fileName);
        return $fileName;
    }

    private function deleteFile(string $folder, ?string $fileName): void
    {
        if (!$fileName) return;
        $path = public_path("upload/{$folder}/{$fileName}");
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    private function buildAttributes(Request $request): array
    {
        $attributes = [];
        $keys   = $request->input('attr_keys', []);
        $values = $request->input('attr_values', []);

        foreach ($keys as $i => $key) {
            $key   = trim($key);
            $value = trim($values[$i] ?? '');
            if ($key !== '' && $value !== '') {
                $attributes[Str::slug($key, '_')] = $value;
            }
        }

        return $attributes;
    }
}
