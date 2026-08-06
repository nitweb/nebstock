<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class DownloadController extends Controller
{
    const DAILY_LIMIT = 20;

    /**
     * Direct one-click download: image + editable/resource file, zipped together.
     * Gated by: logged in -> payment approved -> daily limit not reached.
     */
    public function download(string $slug)
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Please login to download.');
        }

        if ($user->payment_status !== 'approved') {
            return redirect()->route('customer.payment')->with('payment_required', true)
                ->with('error', 'Please complete your one-time payment to unlock downloads.');
        }

        $product = Product::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $todayCount = Download::where('user_id', $user->id)
            ->whereDate('download_date', now()->toDateString())
            ->count();

        if ($todayCount >= self::DAILY_LIMIT) {
            return back()->with('limit_reached', true)
                ->with('error', 'Daily download limit reached (' . self::DAILY_LIMIT . '/day). Please try again tomorrow.');
        }

        // ── Idempotency guard ─────────────────────────────────────────────────
        // If this exact user+product already has a download logged in the last
        // 15 seconds, don't count it again — this protects against any duplicate
        // request source (double click, slow network resubmission, browser/
        // extension retry, etc.) actually deducting 2 from the daily limit for
        // a single user action. We still re-serve the zip either way.
        $alreadyLoggedRecently = Download::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('created_at', '>=', now()->subSeconds(15))
            ->exists();

        // ── Collect the 2 files: cover image + resource file (pdf_file) ──────
        $files = [];

        if ($product->cover_image) {
            $imagePath = public_path('upload/product_covers/' . $product->cover_image);
            if (file_exists($imagePath)) {
                $files['image_' . $product->cover_image] = $imagePath;
            }
        }

        if ($product->pdf_file) {
            $filePath = public_path('upload/product_pdfs/' . $product->pdf_file);
            if (file_exists($filePath)) {
                $files['file_' . $product->pdf_file] = $filePath;
            }
        }

        if (empty($files)) {
            return back()->with('error', 'No downloadable files found for this product.');
        }

        // ── Build zip in a temp folder ────────────────────────────────────────
        $zipFileName = 'download_' . $product->slug . '_' . time() . '.zip';
        $zipPath = storage_path('app/tmp/' . $zipFileName);

        if (!is_dir(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not prepare the download. Please try again.');
        }

        foreach ($files as $nameInZip => $fullPath) {
            $zip->addFile($fullPath, $nameInZip);
        }
        $zip->close();

        // ── Log the download (counts toward today's 20/day limit) ────────────
        // Only log once per user+product within the dedupe window above.
        if (!$alreadyLoggedRecently) {
            Download::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'download_date' => now()->toDateString(),
            ]);
        }

        return response()->download($zipPath, $product->slug . '.zip')->deleteFileAfterSend(true);
    } // End Method

    /**
     * Small AJAX endpoint so the frontend can show remaining downloads today.
     */
    public function remaining()
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return response()->json(['remaining' => 0, 'logged_in' => false]);
        }

        $todayCount = Download::where('user_id', $user->id)
            ->whereDate('download_date', now()->toDateString())
            ->count();

        return response()->json([
            'logged_in' => true,
            'approved' => $user->payment_status === 'approved',
            'remaining' => max(0, self::DAILY_LIMIT - $todayCount),
            'limit' => self::DAILY_LIMIT,
        ]);
    } // End Method
}
