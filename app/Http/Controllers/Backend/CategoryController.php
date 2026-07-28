<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  LIST
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryList()
    {
        // Load all categories with parent & recursive children for tree display
        $categories = Category::with('parent')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('backend.categories.list', compact('categories'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  ADD FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryAdd()
    {
        // All active categories can be a parent (unlimited nesting)
        $allCategories = Category::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Build a flat list with indentation labels
        $parentOptions = $this->buildCategoryOptions($allCategories);

        return view('backend.categories.add', compact('parentOptions'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:categories,slug',
            'parent_id'        => 'nullable|exists:categories,id',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description'      => 'nullable|string|max:1000',
            'sort_order'       => 'nullable|integer|min:0',
            'status'           => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $category              = new Category();
            $category->name        = $request->name;
            $category->slug        = Str::slug($request->slug, '-');
            $category->parent_id   = $request->parent_id ?: null;
            $category->description = $request->description;
            $category->status      = $request->status ?? 'active';
            $category->sort_order  = $request->sort_order ?? 0;

            if ($request->hasFile('image')) {
                $category->image = $this->saveImage($request->file('image'));
            }

            $category->save();
            DB::commit();

            return redirect()->route('backend.categories.list')
                ->with(['message' => 'Category created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Category Store Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with(['message' => 'Failed to create category.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  EDIT FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryEdit(int $id)
    {
        $category = Category::findOrFail($id);

        // Exclude self and all descendants to prevent circular references
        $descendantIds = $this->getDescendantIds($id);
        $excludeIds    = array_merge([$id], $descendantIds);

        $allCategories = Category::active()
            ->whereNotIn('id', $excludeIds)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $parentOptions = $this->buildCategoryOptions($allCategories);

        return view('backend.categories.edit', compact('category', 'parentOptions'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:categories,slug,' . $request->id,
            'parent_id'   => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string|max:1000',
            'sort_order'  => 'nullable|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $category              = Category::findOrFail($request->id);
            $category->name        = $request->name;
            $category->slug        = Str::slug($request->slug, '-');
            $category->parent_id   = $request->parent_id ?: null;
            $category->description = $request->description;
            $category->status      = $request->status ?? 'active';
            $category->sort_order  = $request->sort_order ?? 0;

            if ($request->hasFile('image')) {
                $this->deleteImage($category->image);
                $category->image = $this->saveImage($request->file('image'));
            }

            $category->save();
            DB::commit();

            return redirect()->back()
                ->with(['message' => 'Category updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Category Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with(['message' => 'Failed to update category.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DELETE
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryDelete(int $id)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($id);

            $this->deleteImage($category->image);
            $category->delete();

            DB::commit();

            return redirect()->route('backend.categories.list')
                ->with(['message' => 'Category deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Category Delete Error: ' . $e->getMessage());
            return redirect()->back()
                ->with(['message' => 'Failed to delete category. It may have children or products.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX STORE (Quick Add from product form)
    // ─────────────────────────────────────────────────────────────────────────
    public function CategoryAjaxStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $category            = new Category();
            $category->name      = $request->name;
            $category->slug      = Str::slug($request->slug, '-');
            $category->parent_id = $request->parent_id ?: null;
            $category->status    = 'active';
            $category->sort_order = 0;

            if ($request->hasFile('image')) {
                $category->image = $this->saveImage($request->file('image'));
            }

            $category->save();

            return response()->json([
                'success'  => true,
                'category' => ['id' => $category->id, 'name' => $category->name],
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    /** Save & resize category image, return filename */
    private function saveImage($file): string
    {
        $manager  = new ImageManager(new Driver());
        $fileName = uniqid('cat_', true) . '.' . $file->getClientOriginalExtension();
        $img      = $manager->read($file->getRealPath());
        $img->resize(440, 440);
        $img->save(public_path('upload/category_images/' . $fileName));
        return $fileName;
    }

    /** Delete old image file from disk */
    private function deleteImage(?string $fileName): void
    {
        if (!$fileName) return;
        $path = public_path('upload/category_images/' . $fileName);
        if (file_exists($path)) @unlink($path);
    }

    /**
     * Build a flat array of [id => 'label'] with depth indentation.
     * Used to render <option> lists for parent category selects.
     *
     * @param  \Illuminate\Support\Collection $categories  (flat, ordered)
     * @return array<int, string>
     */
    private function buildCategoryOptions($categories, int $parentId = null, int $depth = 0): array
    {
        $options = [];
        $prefix  = str_repeat('— ', $depth);

        foreach ($categories as $cat) {
            if ($cat->parent_id === $parentId) {
                $options[$cat->id] = $prefix . $cat->name;
                // Recurse into children
                $options += $this->buildCategoryOptions($categories, $cat->id, $depth + 1);
            }
        }

        return $options;
    }

    /**
     * Get all descendant IDs of a category (to prevent circular parent assignment).
     */
    private function getDescendantIds(int $parentId): array
    {
        $ids      = [];
        $children = Category::where('parent_id', $parentId)->pluck('id')->toArray();

        foreach ($children as $childId) {
            $ids[] = $childId;
            $ids   = array_merge($ids, $this->getDescendantIds($childId));
        }

        return $ids;
    }
}
