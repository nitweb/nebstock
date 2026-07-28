<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BlogCategoriesController extends Controller
{
    public function BlogCategoriesList()
    {
        $blog_categories_list = BlogCategories::orderBy('id', 'desc')->get();
        return view('backend.blog_categories.list', compact('blog_categories_list'));
    } // End Method

    public function BlogCategoriesAdd()
    {
        return view('backend.blog_categories.add');
    } // End Method

    public function BlogCategoriesStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'blog_category_name' => 'required|string|max:255',
            ],
            [
                'blog_category_name.required' => 'Blog Category name is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $blog_categories_data = new BlogCategories();
            $blog_categories_data->blog_category_name = $request->blog_category_name;
            $blog_categories_data->save();

            DB::commit();

            return redirect()
                ->route('backend.blog_categories.list')
                ->with([
                    'message' => 'Blog Category created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating Blog Category: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Blog Category.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function BlogCategoriesEdit($id)
    {
        $blog_categories_info = BlogCategories::findOrFail($id);
        return view('backend.blog_categories.edit', compact('blog_categories_info'));
    } // End Method

    public function BlogCategoriesUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'blog_category_name' => 'required|string|max:255',
            ],
            [
                'blog_category_name.required' => 'Blog Category name is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $blog_categories_data = BlogCategories::findOrFail($request->id);

            if ($request->filled('blog_category_name')) {
                $blog_categories_data->blog_category_name = $request->blog_category_name;
            }

            $blog_categories_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Blog Category updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Blog Category: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Blog Category.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function BlogCategoriesDelete($id)
    {
        try {
            DB::beginTransaction();

            $blog_categories_data = BlogCategories::findOrFail($id);

            $blog_categories_data->delete();

            DB::commit();

            return redirect()
                ->route('backend.blog_categories.list')
                ->with([
                    'message' => 'Blog Category deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Blog Category: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Blog Category.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function BlogCategoriesAjaxStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'blog_category_name' => 'required|string|max:255|unique:blog_categories,blog_category_name',
            ],
            [
                'blog_category_name.required' => 'Category name is required',
                'blog_category_name.unique' => 'This category already exists',
            ],
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }

        try {
            $category = BlogCategories::create([
                'blog_category_name' => $request->blog_category_name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->blog_category_name,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to create category.',
                ],
                500,
            );
        }
    }
}
