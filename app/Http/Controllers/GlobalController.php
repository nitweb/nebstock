<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GlobalController extends Controller
{
    public function StatusUpdate(Request $request)
    {
        // 1. Validation
        $request->validate([
            'model' => 'required|string',
            'id' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'column' => 'sometimes|string', // Optional: defaults to 'status'
        ]);

        try {
            $modelClass = $request->input('model');
            $recordId = $request->input('id');
            $status = $request->input('status');
            // Use 'status' as the default column if not provided
            $statusColumn = $request->input('column', 'status');

            // 2. Security: Whitelist of allowed models to prevent abuse
            $allowedModels = [
                \App\Models\Slider::class,
                \App\Models\Product::class,
                \App\Models\Blog::class,
                \App\Models\Coupon::class, // এটা যোগ করুন
            ];

            if (!in_array($modelClass, $allowedModels)) {
                return response()->json(['success' => false, 'message' => 'Invalid model specified.'], 403); // 403 Forbidden
            }

            // 3. Find the record and update its status
            $record = $modelClass::findOrFail($recordId);

            // Use the dynamic column name to set the status
            $record->{$statusColumn} = $status;
            $record->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update status.',
                ],
                500,
            );
        }
    } // End Method
}
