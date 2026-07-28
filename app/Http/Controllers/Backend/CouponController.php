<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    // ========== List ==========
    public function CouponList()
    {
        $coupons = Coupon::latest()->get();
        return view('backend.coupons.list', compact('coupons'));
    }

    // ========== Add Form ==========
    public function CouponAdd()
    {
        return view('backend.coupons.add');
    }

    // ========== Store ==========
    public function CouponStore(Request $request)
    {
        $request->validate(
            [
                'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code',
                'coupon_type' => 'required|in:fixed,percent',
                'coupon_value' => 'required|numeric|min:0',
                'minimum_amount' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'status' => 'required|in:active,inactive',
            ],
            [
                'coupon_code.unique' => 'This coupon code already exists.',
                'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            ],
        );

        try {
            Coupon::create([
                'coupon_code' => strtoupper(trim($request->coupon_code)),
                'coupon_type' => $request->coupon_type,
                'coupon_value' => $request->coupon_value,
                'minimum_amount' => $request->minimum_amount ?? 0,
                'usage_limit' => $request->usage_limit,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('backend.coupon.list')
                ->with(['message' => 'Coupon created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Coupon Create Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to create coupon.', 'alert-type' => 'error']);
        }
    }

    // ========== Edit Form ==========
    public function CouponEdit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.coupons.edit', compact('coupon'));
    }

    // ========== Update ==========
    public function CouponUpdate(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code,' . $request->id,
            'coupon_type' => 'required|in:fixed,percent',
            'coupon_value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $coupon = Coupon::findOrFail($request->id);
            $coupon->update([
                'coupon_code' => strtoupper(trim($request->coupon_code)),
                'coupon_type' => $request->coupon_type,
                'coupon_value' => $request->coupon_value,
                'minimum_amount' => $request->minimum_amount ?? 0,
                'usage_limit' => $request->usage_limit,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            return redirect()
                ->back()
                ->with(['message' => 'Coupon updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Coupon Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to update coupon.', 'alert-type' => 'error']);
        }
    }

    // ========== Delete ==========
    public function CouponDelete($id)
    {
        try {
            Coupon::findOrFail($id)->delete();

            return redirect()
                ->route('backend.coupon.list')
                ->with(['message' => 'Coupon deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Coupon Delete Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to delete coupon.', 'alert-type' => 'error']);
        }
    }

    // ========== Generate Random Code ==========
    public function generateCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Coupon::where('coupon_code', $code)->exists());

        return response()->json(['code' => $code]);
    }
}
