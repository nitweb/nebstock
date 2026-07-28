<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    // ── List ──────────────────────────────────────────────────────────────────
    public function BlogList()
    {
        $blog_list = Blog::with(['blogCategory', 'submittedBy'])
            ->latest()
            ->get();
        $pending_count = Blog::where('blog_status', 'pending')->count();

        return view('backend.blog.list', compact('blog_list', 'pending_count'));
    }

    // ── Add / Store (admin নিজে লেখে) ────────────────────────────────────────
    public function BlogAdd()
    {
        $blog_categories = BlogCategories::orderBy('blog_category_name')->get();
        return view('backend.blog.add', compact('blog_categories'));
    }

    public function BlogStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'blog_title' => 'required|string|max:255',
            'blog_slug' => 'required|string|max:255|unique:blogs,blog_slug',
            'blog_short_description' => 'nullable|string',
            'blog_long_description' => 'required|string',
            'blog_category_id' => 'required|integer|exists:blog_categories,id',
            'blog_tags' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $blog = new Blog();
            $blog->blog_title = $request->blog_title;
            $blog->blog_slug = Str::slug($request->blog_slug, '-');
            $blog->blog_short_description = $request->blog_short_description;
            $blog->blog_long_description = $request->blog_long_description;
            $blog->blog_category_id = $request->blog_category_id;
            $blog->blog_published_by = Auth::guard('admin')->id();
            $blog->blog_published_date = now();
            $blog->blog_status = 'active'; // admin এর blog সরাসরি active

            $blog->blog_tags = $this->processTags($request->blog_tags);

            if ($request->hasFile('blog_image')) {
                $blog->blog_image = $this->saveImage($request->file('blog_image'));
            }

            $blog->save();
            DB::commit();

            return redirect()
                ->route('backend.blog.list')
                ->with(['message' => 'Blog created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Blog Store Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to create blog.', 'alert-type' => 'error']);
        }
    }

    // ── Edit / Update ─────────────────────────────────────────────────────────
    public function BlogEdit($id)
    {
        $blog_info = Blog::findOrFail($id);
        $blog_categories = BlogCategories::orderBy('blog_category_name')->get();
        return view('backend.blog.edit', compact('blog_info', 'blog_categories'));
    }

    public function BlogUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'blog_title' => 'required|string|max:255',
            'blog_slug' => 'required|string|max:255|unique:blogs,blog_slug,' . $request->id,
            'blog_short_description' => 'nullable|string',
            'blog_long_description' => 'required|string',
            'blog_category_id' => 'required|integer|exists:blog_categories,id',
            'blog_tags' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($request->id);
            $blog->blog_title = $request->blog_title;
            $blog->blog_slug = Str::slug($request->blog_slug, '-');
            $blog->blog_short_description = $request->blog_short_description;
            $blog->blog_long_description = $request->blog_long_description;
            $blog->blog_category_id = $request->blog_category_id;
            $blog->blog_tags = $this->processTags($request->blog_tags);

            if ($request->hasFile('blog_image')) {
                $this->deleteImage($blog->blog_image);
                $blog->blog_image = $this->saveImage($request->file('blog_image'));
            }

            $blog->save();
            DB::commit();

            return redirect()
                ->back()
                ->with(['message' => 'Blog updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Blog Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to update blog.', 'alert-type' => 'error']);
        }
    }

    // ── Delete ────────────────────────────────────────────────────────────────
    public function BlogDelete($id)
    {
        try {
            DB::beginTransaction();
            $blog = Blog::findOrFail($id);
            $this->deleteImage($blog->blog_image);
            $blog->delete();
            DB::commit();

            return redirect()
                ->route('backend.blog.list')
                ->with(['message' => 'Blog deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with(['message' => 'Failed to delete blog.', 'alert-type' => 'error']);
        }
    }

    // ── Approve (user submitted blog) ─────────────────────────────────────────
    public function BlogApprove(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // Slug unique check
            $slug = Str::slug($blog->blog_title, '-');
            $count = Blog::where('blog_slug', $slug)->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . $id;
            }

            $blog->update([
                'blog_status' => 'active',
                'blog_slug' => $slug,
                'blog_published_by' => Auth::guard('admin')->id(),
                'blog_published_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Blog approved and published!',
            ]);
        } catch (\Throwable $e) {
            Log::error('Blog Approve Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to approve.'], 500);
        }
    }

    // ── Reject (user submitted blog) ──────────────────────────────────────────
    public function BlogReject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            Blog::findOrFail($id)->update([
                'blog_status' => 'rejected',
                'rejection_reason' => $request->reason,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Blog rejected.',
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to reject.'], 500);
        }
    }

    // ── Private Helpers ───────────────────────────────────────────────────────
    private function processTags(?string $tags): ?string
    {
        if (!$tags) {
            return null;
        }
        $arr = json_decode($tags, true);
        if (is_array($arr)) {
            return implode(',', array_column($arr, 'value'));
        }
        return $tags;
    }

    private function saveImage($file): string
    {
        $manager = new ImageManager(new Driver());
        $file_name = uniqid('blog_', true) . '.' . $file->getClientOriginalExtension();
        $img = $manager->read($file->getRealPath());
        $img->resize(830, 553);
        $img->save(public_path('upload/blog_image/') . $file_name);
        return $file_name;
    }

    private function deleteImage(?string $image): void
    {
        if (!$image) {
            return;
        }
        $path = public_path('upload/blog_image/' . $image);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    public function BlogContent(int $id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json([
            'success' => true,
            'content' => $blog->blog_long_description,
        ]);
    }
}
