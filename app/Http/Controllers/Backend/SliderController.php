<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function SliderList()
    {
        $slider_list = Slider::orderBy('id', 'asc')->get();
        return view('backend.slider.list', compact('slider_list'));
    } // End Method

    public function SliderAdd()
    {
        return view('backend.slider.add');
    } // End Method

    public function SliderStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ],
            [
                'slider_image.image' => 'Slider image must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $slider_data = new Slider();

            if ($request->hasFile('slider_image')) {
                $file = $request->file('slider_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('slider_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(1600, 550);
                $img->save(public_path('upload/slider_image/') . $file_name);
                $slider_data->slider_image = $file_name;
            }

            $slider_data->save();

            DB::commit();

            return redirect()
                ->route('backend.slider.list')
                ->with([
                    'message' => 'Slider created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            if (isset($filename) && file_exists(public_path('upload/slider_image/' . $filename))) {
                @unlink(public_path('upload/slider_image/' . $filename));
            }
            DB::rollBack();
            Log::error('Error creating Slider: ' . $e->getMessage() . $e->getLine());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Slider.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function SliderEdit($id)
    {
        $slider_info = Slider::findOrFail($id);
        return view('backend.slider.edit', compact('slider_info'));
    } // End Method

    public function SliderUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ],
            [
                'slider_image.image' => 'Slider image must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $slider_data = Slider::findOrFail($request->id);

            if ($request->hasFile('slider_image')) {
                $oldImage = public_path('upload/slider_image/' . $slider_data->slider_image);
                if ($slider_data->slider_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('slider_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('team_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(1600, 550);
                $img->save(public_path('upload/slider_image/') . $file_name);
                $slider_data->slider_image = $file_name;
            }

            $slider_data->save();

            DB::commit();

            return redirect()
                 ->route('backend.slider.list') 
                ->with([
                    'message' => 'Slider updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Slider: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Slider.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function SliderDelete($id)
    {
        try {
            DB::beginTransaction();

            $slider_data = Slider::findOrFail($id);

            if ($slider_data->slider_image) {
                $oldImage = public_path('upload/slider_image/' . $slider_data->slider_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $slider_data->delete();

            DB::commit();

            return redirect()
                ->route('backend.slider.list')
                ->with([
                    'message' => 'Slider deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Slider: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Slider.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
