<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MissionVision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MissionVisionController extends Controller
{
    public function MissionVisionList()
    {
        $mission_vision_list = MissionVision::latest()->get();
        return view('backend.mission_vision.list', compact('mission_vision_list'));
    } // End Method

    public function MissionVisionEdit($id)
    {
        $mission_vision_info = MissionVision::findOrFail($id);
        return view('backend.mission_vision.edit', compact('mission_vision_info'));
    } // End Method

    public function MissionVisionUpdate(Request $request)
    {
        $request->validate([
            'mission_vision_icon' => 'required|string|max:50',
            'mission_vision_title' => 'required|string|max:255',
            'mission_vision_description' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $mission_vision_data = MissionVision::findOrFail($request->id);

            $mission_vision_data->mission_vision_icon = $request->mission_vision_icon;
            $mission_vision_data->mission_vision_title = $request->mission_vision_title;
            $mission_vision_data->mission_vision_description = $request->mission_vision_description;

            $mission_vision_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Mission/Vision/Values Updated Successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Mission/Vision/Values: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to update Mission/Vision/Values.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
