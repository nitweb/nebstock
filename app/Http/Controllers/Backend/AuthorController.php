<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AuthorController extends Controller
{
    public function AuthorList()
    {
        $authors = Author::latest()->get();
        return view('backend.authors.list', compact('authors'));
    }

    public function AuthorAdd()
    {
        return view('backend.authors.add');
    }

    public function AuthorStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|max:255|unique:authors,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $author              = new Author();
            $author->name        = $request->name;
            $author->slug        = Str::slug($request->slug, '-');
            $author->description = $request->description;
            $author->status      = $request->status ?? 'active';

            if ($request->hasFile('image')) {
                $manager  = new ImageManager(new Driver());
                $file     = $request->file('image');
                $fileName = uniqid('author_', true) . '.' . $file->getClientOriginalExtension();
                $img      = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/author_images/' . $fileName));
                $author->image = $fileName;
            }

            $author->save();
            DB::commit();

            return redirect()->route('backend.authors.list')
                ->with(['message' => 'Author created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Author Store Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with(['message' => 'Failed to create author.', 'alert-type' => 'error']);
        }
    }

    public function AuthorEdit(int $id)
    {
        $author = Author::findOrFail($id);
        return view('backend.authors.edit', compact('author'));
    }

    public function AuthorUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => 'required|exists:authors,id',
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|max:255|unique:authors,slug,' . $request->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $author              = Author::findOrFail($request->id);
            $author->name        = $request->name;
            $author->slug        = Str::slug($request->slug, '-');
            $author->description = $request->description;
            $author->status      = $request->status ?? 'active';

            if ($request->hasFile('image')) {
                // Delete old image
                if ($author->image) {
                    $old = public_path('upload/author_images/' . $author->image);
                    if (file_exists($old)) @unlink($old);
                }

                $manager  = new ImageManager(new Driver());
                $file     = $request->file('image');
                $fileName = uniqid('author_', true) . '.' . $file->getClientOriginalExtension();
                $img      = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/author_images/' . $fileName));
                $author->image = $fileName;
            }

            $author->save();
            DB::commit();

            return redirect()->back()
                ->with(['message' => 'Author updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Author Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with(['message' => 'Failed to update author.', 'alert-type' => 'error']);
        }
    }

    public function AuthorDelete(int $id)
    {
        try {
            DB::beginTransaction();

            $author = Author::findOrFail($id);

            if ($author->image) {
                $old = public_path('upload/author_images/' . $author->image);
                if (file_exists($old)) @unlink($old);
            }

            $author->delete();
            DB::commit();

            return redirect()->route('backend.authors.list')
                ->with(['message' => 'Author deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Author Delete Error: ' . $e->getMessage());
            return redirect()->back()
                ->with(['message' => 'Failed to delete author.', 'alert-type' => 'error']);
        }
    }

    /** AJAX: return authors as JSON (for select2 / search) */
    public function AuthorSearch(Request $request)
    {
        $authors = Author::active()
            ->when($request->q, fn($q) => $q->where('name', 'like', '%' . $request->q . '%'))
            ->select('id', 'name')
            ->limit(20)
            ->get();

        return response()->json($authors);
    }

    public function AuthorAjaxStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|max:255|unique:authors,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $author              = new \App\Models\Author();
            $author->name        = $request->name;
            $author->slug        = \Illuminate\Support\Str::slug($request->slug, '-');
            $author->description = $request->description;
            $author->status      = 'active';

            if ($request->hasFile('image')) {
                $manager  = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $file     = $request->file('image');
                $fileName = uniqid('author_', true) . '.' . $file->getClientOriginalExtension();
                $img      = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/author_images/' . $fileName));
                $author->image = $fileName;
            }

            $author->save();

            return response()->json([
                'success' => true,
                'author'  => [
                    'id'   => $author->id,
                    'name' => $author->name,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
