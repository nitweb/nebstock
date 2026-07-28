<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AboutCompanyController extends Controller
{
    public function AboutCompanyList()
    {
        $about_list = AboutCompany::latest()->get();
        return view('backend.about_company.list', compact('about_list'));
    } // End Method

    public function AboutCompanyEdit($id)
    {
        $about_info = AboutCompany::findOrFail($id);
        return view('backend.about_company.edit', compact('about_info'));
    } // End Method

    public function AboutCompanyUpdate(Request $request)
    {
        $request->validate([
            'about_description' => 'required|string',
            'about_youtube' => 'nullable|string|max:500',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $about_data = AboutCompany::findOrFail($request->id);

            $about_data->about_description = $request->about_description;
            $about_data->about_youtube = $request->about_youtube;

            if ($request->hasFile('about_image')) {
                $oldImage = public_path('upload/about_image/' . $about_data->about_image);
                if ($about_data->about_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('about_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('about_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                // $img->resize(615, 460);
                $img->save(public_path('upload/about_image/') . $file_name);
                $about_data->about_image = $file_name;
            }

            $about_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'About Company Updated Successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating About Company: ' . $e->getMessage() . 'line-' . $e->getLine());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to update About Company.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
