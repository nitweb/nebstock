<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CustomerController extends Controller
{
    // CustomerList()
    public function CustomerList()
    {
        $customers = User::whereIn('role', ['customer', 'guest'])
            ->withCount('downloads')
            ->latest()
            ->paginate(20);

        return view('backend.customer.list', compact('customers'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  ADD FORM
    // ─────────────────────────────────────────────────────────────────────────
    public function CustomerAdd()
    {
        return view('backend.customer.add');
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────────────────
    public function CustomerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photo = 'avatar.png';
        if ($request->hasFile('photo')) {
            $photo = $this->savePhoto($request->file('photo'));
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'photo' => $photo,
            'role' => 'customer',
            'status' => $request->status,
        ]);

        return redirect()
            ->route('backend.customers.list')
            ->with(['message' => 'Customer created successfully!', 'alert-type' => 'success']);
    }

    // CustomerEdit()
    public function CustomerEdit($id)
    {
        $customer = User::where('id', $id)
            ->whereIn('role', ['customer', 'guest'])
            ->firstOrFail();

        return view('backend.customer.edit', compact('customer'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────────────────
    public function CustomerUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = User::where('id', $request->id)
            ->whereIn('role', ['customer', 'guest'])
            ->firstOrFail();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->status = $request->status;

        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $this->deletePhoto($customer->photo);
            $customer->photo = $this->savePhoto($request->file('photo'));
        }

        $customer->save();

        return redirect()
            ->back()
            ->with(['message' => 'Customer updated successfully!', 'alert-type' => 'success']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DETAIL + ORDER HISTORY
    // ─────────────────────────────────────────────────────────────────────────
    public function CustomerDetail($id)
    {
        $customer = User::where('id', $id)
            ->whereIn('role', ['customer', 'guest'])
            ->firstOrFail();

        $downloads = \App\Models\Download::with('product')
            ->where('user_id', $id)
            ->latest()
            ->paginate(10);

        $totalDownloads = \App\Models\Download::where('user_id', $id)->count();
        $todayDownloads = \App\Models\Download::where('user_id', $id)
            ->whereDate('download_date', now()->toDateString())
            ->count();

        return view('backend.customer.detail', compact('customer', 'downloads', 'totalDownloads', 'todayDownloads'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  TOGGLE STATUS (AJAX)
    // ─────────────────────────────────────────────────────────────────────────
    public function ToggleStatus(Request $request)
    {
        $customer = User::where('id', $request->id)
            ->whereIn('role', ['customer', 'guest'])
            ->firstOrFail();
        $customer->status = $customer->status == '1' ? '0' : '1';
        $customer->save();

        return response()->json([
            'success' => true,
            'status' => $customer->status,
            'message' => $customer->status == '1' ? 'Customer activated successfully.' : 'Customer deactivated successfully.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DELETE
    // ─────────────────────────────────────────────────────────────────────────
    public function CustomerDelete($id)
    {
        $customer = User::where('id', $id)
            ->whereIn('role', ['customer', 'guest'])
            ->firstOrFail();
        $this->deletePhoto($customer->photo);
        $customer->delete();

        return redirect()
            ->route('backend.customers.list')
            ->with(['message' => 'Customer deleted successfully!', 'alert-type' => 'success']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  BULK DELETE (AJAX)
    // ─────────────────────────────────────────────────────────────────────────
    public function CustomerBulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        $customers = User::whereIn('id', $request->ids)
            ->whereIn('role', ['customer', 'guest'])
            ->get();
        foreach ($customers as $customer) {
            $this->deletePhoto($customer->photo);
            $customer->delete();
        }

        return response()->json(['success' => true, 'message' => 'Selected customers deleted successfully.']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────
    private function savePhoto($file): string
    {
        $manager = new ImageManager(new Driver());
        $fileName = uniqid('customer_', true) . '.' . $file->getClientOriginalExtension();
        $img = $manager->read($file->getRealPath());
        $img->resize(300, 300);
        $img->save(public_path('upload/customer_images/' . $fileName));
        return $fileName;
    }

    private function deletePhoto(?string $photo): void
    {
        if (!$photo || $photo === 'avatar.png') {
            return;
        }
        $path = public_path('upload/customer_images/' . $photo);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}