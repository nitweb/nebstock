<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
            ->with(['categories'])
            ->get();

        return view('backend.products.list', compact('products'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  ADD FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductAdd()
    {
        $categories = Category::active()->with('recursiveChildren')->root()->orderBy('sort_order')->get();

        return view('backend.products.add', compact('categories'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductStore(Request $request)
    {
        $rules = [
            'name'           => 'required|string',
            'status'         => 'required|in:active,inactive',
            'cover_image'    => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'file'           => 'required|file',
            'category_ids'   => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'category_ids.required' => 'Please select a category / sub-category.',
            'cover_image.required'  => 'Product image is required.',
            'file.required'         => 'Product file is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());

            $product = new Product();
            $product->product_mode = 'selling';
            $product->product_type = 'other';
            $product->name         = $request->name;
            $product->slug         = $this->uniqueSlug($request->name);
            $product->status       = $request->status;
            $product->price        = 0; // no per-product price — payment is a one-time site-wide unlock
            $product->quantity     = 0;
            $product->stock_status = 'in_stock';
            $product->is_featured  = false;

            $product->cover_image = $this->saveImage($manager, $request->file('cover_image'), 'product_covers');
            $product->pdf_file    = $this->saveFile($request->file('file'), 'product_pdfs', 'file_');

            $product->save();

            $product->categories()->sync($request->category_ids);

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
        $product = Product::with(['categories'])->findOrFail($id);

        $categories   = Category::active()->with('recursiveChildren')->root()->orderBy('sort_order')->get();
        $selectedCats = $product->categories->pluck('id')->toArray();

        return view('backend.products.edit', compact('product', 'categories', 'selectedCats'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────────────
    public function ProductUpdate(Request $request)
    {
        $rules = [
            'id'             => 'required|exists:products,id',
            'name'           => 'required|string',
            'status'         => 'required|in:active,inactive',
            'cover_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'file'           => 'nullable|file',
            'category_ids'   => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'category_ids.required' => 'Please select a category / sub-category.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());
            $product = Product::findOrFail($request->id);

            $product->name   = $request->name;
            $product->status = $request->status;

            if ($request->name !== $product->getOriginal('name')) {
                $product->slug = $this->uniqueSlug($request->name, $product->id);
            }

            if ($request->hasFile('cover_image')) {
                $this->deleteFile('product_covers', $product->cover_image);
                $product->cover_image = $this->saveImage($manager, $request->file('cover_image'), 'product_covers');
            }

            if ($request->hasFile('file')) {
                $this->deleteFile('product_pdfs', $product->pdf_file);
                $product->pdf_file = $this->saveFile($request->file('file'), 'product_pdfs', 'file_');
            }

            $product->save();

            $product->categories()->sync($request->category_ids);

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

            $product = Product::findOrFail($id);

            $this->deleteFile('product_covers', $product->cover_image);
            $this->deleteFile('product_pdfs', $product->pdf_file);

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
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name, '-');
        $slug = $base;
        $i    = 1;

        while (
            Product::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

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
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();
        $fileName     = uniqid($prefix, true) . '_' . Str::slug($originalName) . '.' . $extension;
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
}
