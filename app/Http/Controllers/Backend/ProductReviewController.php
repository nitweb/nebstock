<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    public function storeReview(Request $request)
    {
        $validated = $request->validate(
            [
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'phone' => 'nullable|string|max:20',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000',
            ],
            [
                'rating.required' => 'Please select a star rating.',
                'rating.min' => 'Minimum rating is 1 star.',
                'rating.max' => 'Maximum rating is 5 stars.',
            ],
        );

        try {
            ProductReview::create([
                'product_id' => $validated['product_id'],
                'name' => trim($validated['name']),
                'email' => trim($validated['email']),
                'phone' => $validated['phone'] ?? null,
                'rating' => $validated['rating'],
                'comment' => trim($validated['comment']),
            ]);

            return back()->with([
                'message' => '✅ Review submitted successfully!',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error('Review submit failed', [
                'error' => $e->getMessage(),
                'product_id' => $request->product_id,
            ]);

            return back()
                ->withInput()
                ->with([
                    'message' => '❌ Failed to submit review. Please try again.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ProductReviewList()
    {
        $product_review_list = ProductReview::orderBy('id', 'desc')->get();
        return view('backend.product_reviews.list', compact('product_review_list'));
    } // End Method

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:product_reviews,id',
            'status' => 'required|in:accept,pending,reject',
        ]);

        try {
            $review = ProductReview::findOrFail($request->id);
            $review->status = $request->status;
            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $review->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Product review status update failed: ' . $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update status.',
                ],
                500,
            );
        }
    } // End Method

    public function ProductReviewDelete($id)
    {
        try {
            DB::beginTransaction();

            $product_review_data = ProductReview::findOrFail($id);

            $product_review_data->delete();

            DB::commit();

            return redirect()
                ->route('product_review.list')
                ->with([
                    'message' => 'Product Review deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Product Review: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Product Review.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ProductReviewBulkDelete(Request $request)
    {
        try {
            $ids = $request->ids;

            if (empty($ids)) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => 'No forms selected for deletion.',
                        'alert-type' => 'warning',
                    ]);
            }

            DB::beginTransaction();

            ProductReview::whereIn('id', $ids)->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Selected product reviews deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error bulk deleting product reviews: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete selected product reviews.',
                    'alert-type' => 'error',
                ]);
        }
    }
}
