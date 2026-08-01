<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SiteSettingsController extends Controller
{
    public function FontAwesome()
    {
        return view('backend.settings.font_awesome');
    } // End Method

    public function SiteSettings()
    {
        $site_settings_info = SiteSettings::first();
        return view('backend.settings.site_settings', compact('site_settings_info'));
    } // End Method

    public function SiteSettingsUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'site_header_logo' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp',
                'site_footer_logo' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp',
                'site_address' => 'required|string|max:255',
                'site_email' => 'required|email|max:255',
                'site_email_alt' => 'nullable|email|max:255',
                'site_phone' => 'required|string|max:50',
                'site_phone_alt' => 'nullable|string|max:50',
                'site_description' => 'nullable|string',
                'site_copyright' => 'required|string|max:255',
                'site_google_map' => 'nullable|string',
                'registration_fee' => 'required|numeric|min:0',
                'bkash_merchant_number' => 'nullable|string|max:20',
            ],
            [
                'site_header_logo.image' => 'Header logo must be an image file',
                'site_footer_logo.image' => 'Footer logo must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $site_settings = SiteSettings::firstOrFail();

            // Handle header logo upload
            if ($request->hasFile('site_header_logo')) {
                $oldHeaderLogo = public_path('upload/site_settings/' . $site_settings->site_header_logo);
                if ($site_settings->site_header_logo && file_exists($oldHeaderLogo)) {
                    @unlink($oldHeaderLogo);
                }
                $file = $request->file('site_header_logo');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('header_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                // $img->resize(147, 39);
                $img->save(public_path('upload/site_settings/') . $file_name);
                $site_settings->site_header_logo = 'upload/site_settings/' . $file_name;
            }

            // Handle footer logo upload
            if ($request->hasFile('site_footer_logo')) {
                $oldFooterLogo = public_path('upload/site_settings/' . $site_settings->site_footer_logo);
                if ($site_settings->site_footer_logo && file_exists($oldFooterLogo)) {
                    @unlink($oldFooterLogo);
                }
                $file = $request->file('site_footer_logo');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('footer_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                // $img->resize(147, 39);
                $img->save(public_path('upload/site_settings/') . $file_name);
                $site_settings->site_footer_logo = 'upload/site_settings/' . $file_name;
            }

            // Update other fields
            $site_settings->site_address = $request->site_address;
            $site_settings->site_email = $request->site_email;
            $site_settings->site_email_alt = $request->site_email_alt;
            $site_settings->site_phone = $request->site_phone;
            $site_settings->site_phone_alt = $request->site_phone_alt;
            $site_settings->site_description = $request->site_description;
            $site_settings->site_copyright = $request->site_copyright;
            $site_settings->site_google_map = $request->site_google_map;
            $site_settings->registration_fee = $request->registration_fee;
            $site_settings->bkash_merchant_number = $request->bkash_merchant_number;

            $site_settings->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Site settings updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Site Settings: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Site Settings.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
