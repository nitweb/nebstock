<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Font;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class FontController extends Controller
{
    /** Allowed font file extensions (checked by extension, not MIME —
     *  browsers send inconsistent MIME types like application/octet-stream
     *  for .ttf/.otf, which Laravel's `mimes:` rule rejects). */
    private const FONT_EXTENSIONS = ['ttf', 'otf', 'woff', 'woff2', 'zip'];
    // ─────────────────────────────────────────────────────────────────────────
    //  LIST
    // ─────────────────────────────────────────────────────────────────────────
    public function FontList()
    {
        $fonts = Font::latest()->get();

        return view('backend.fonts.list', compact('fonts'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  ADD FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function FontAdd()
    {
        return view('backend.fonts.add');
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────────────
    public function FontStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:fonts,slug',
            'designer'       => 'nullable|string|max:255',
            'license'        => 'required|in:free,personal_use,premium,open_font_license',
            'style'          => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'font_file'      => ['required', 'file', 'max:10240', $this->fontExtensionRule()],
            'preview_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured'    => 'nullable|boolean',
            'status'         => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $font               = new Font();
            $font->name         = $request->name;
            $font->slug         = Str::slug($request->slug, '-');
            $font->designer     = $request->designer;
            $font->license      = $request->license;
            $font->style        = $request->style;
            $font->description  = $request->description;
            $font->is_featured  = $request->boolean('is_featured');
            $font->status       = $request->status ?? 'active';

            // Font file — filename is AUTOMATIC: derived from the font name
            // (slug + original extension), not a random string.
            if ($request->hasFile('font_file')) {
                $font->font_file = $this->saveFontFile($request->file('font_file'), $font->slug);
            }

            if ($request->hasFile('preview_image')) {
                $font->preview_image = $this->savePreviewImage($request->file('preview_image'), $font->slug);
            }

            $font->save();
            DB::commit();

            return redirect()->route('backend.fonts.list')
                ->with(['message' => 'Font uploaded successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Font Store Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with(['message' => 'Failed to upload font.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  EDIT FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function FontEdit(int $id)
    {
        $font = Font::findOrFail($id);

        return view('backend.fonts.edit', compact('font'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────────────
    public function FontUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'             => 'required|exists:fonts,id',
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:fonts,slug,' . $request->id,
            'designer'       => 'nullable|string|max:255',
            'license'        => 'required|in:free,personal_use,premium,open_font_license',
            'style'          => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'font_file'      => ['nullable', 'file', 'max:10240', $this->fontExtensionRule()],
            'preview_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured'    => 'nullable|boolean',
            'status'         => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $font               = Font::findOrFail($request->id);
            $font->name         = $request->name;
            $font->slug         = Str::slug($request->slug, '-');
            $font->designer     = $request->designer;
            $font->license      = $request->license;
            $font->style        = $request->style;
            $font->description  = $request->description;
            $font->is_featured  = $request->boolean('is_featured');
            $font->status       = $request->status ?? 'active';

            if ($request->hasFile('font_file')) {
                $this->deleteFontFile($font->font_file);
                $font->font_file = $this->saveFontFile($request->file('font_file'), $font->slug);
            }

            if ($request->hasFile('preview_image')) {
                $this->deletePreviewImage($font->preview_image);
                $font->preview_image = $this->savePreviewImage($request->file('preview_image'), $font->slug);
            }

            $font->save();
            DB::commit();

            return redirect()->back()
                ->with(['message' => 'Font updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Font Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with(['message' => 'Failed to update font.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DELETE
    // ─────────────────────────────────────────────────────────────────────────
    public function FontDelete(int $id)
    {
        try {
            DB::beginTransaction();

            $font = Font::findOrFail($id);

            $this->deleteFontFile($font->font_file);
            $this->deletePreviewImage($font->preview_image);
            $font->delete();

            DB::commit();

            return redirect()->route('backend.fonts.list')
                ->with(['message' => 'Font deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Font Delete Error: ' . $e->getMessage());
            return redirect()->back()
                ->with(['message' => 'Failed to delete font.', 'alert-type' => 'error']);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Custom validation rule: checks the uploaded file's EXTENSION only.
     * We avoid Laravel's `mimes:` rule here because browsers send inconsistent
     * MIME types for font files (e.g. .ttf as application/octet-stream),
     * which causes valid font files to fail MIME-based validation.
     */
    private function fontExtensionRule()
    {
        return function ($attribute, $value, $fail) {
            if (!$value) return;
            $ext = strtolower($value->getClientOriginalExtension());
            if (!in_array($ext, self::FONT_EXTENSIONS, true)) {
                $fail('The ' . $attribute . ' field must be a file of type: ' . implode(', ', self::FONT_EXTENSIONS) . '.');
            }
        };
    }

    /**
     * Save the uploaded font file. The stored filename is AUTOMATIC — it is
     * always derived from the font's slug (e.g. "roboto-bold.ttf"), never a
     * random uniqid. Re-uploading the same font name overwrites the old file.
     */
    private function saveFontFile($file, string $slug): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName  = $slug . '.' . $extension;

        $destination = public_path('upload/fonts');
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);

        return $fileName;
    }

    /** Preview/specimen image — also named after the font slug. */
    private function savePreviewImage($file, string $slug): string
    {
        $manager  = new ImageManager(new Driver());
        $fileName = $slug . '.' . $file->getClientOriginalExtension();

        $destination = public_path('upload/fonts/preview');
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $img = $manager->read($file->getRealPath());
        $img->resize(500, 280);
        $img->save($destination . '/' . $fileName);

        return $fileName;
    }

    private function deleteFontFile(?string $fileName): void
    {
        if (!$fileName) return;
        $path = public_path('upload/fonts/' . $fileName);
        if (file_exists($path)) @unlink($path);
    }

    private function deletePreviewImage(?string $fileName): void
    {
        if (!$fileName) return;
        $path = public_path('upload/fonts/preview/' . $fileName);
        if (file_exists($path)) @unlink($path);
    }
}