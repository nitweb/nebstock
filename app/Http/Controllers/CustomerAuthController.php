<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Product;
use App\Models\SiteSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerResetMail;

class CustomerAuthController extends Controller
{
    /* ===== Login ===== */
    public function login()
    {
        return view('frontend.customer.auth.login');
    } // End Method

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (
            Auth::guard('user')->attempt([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'customer',
                'status' => '1',
            ])
        ) {
            $user = Auth::guard('user')->user();

            // Always land on the customer dashboard after login (not a stale/wrong intended URL).
            session()->forget('url.intended');
            return redirect()->route('index')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->with('error', 'Invalid credentials')->withInput();
    }

    /* ===== Register ===== */
    public function register()
    {
        return view('frontend.customer.auth.register');
    } // End Method

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // NOTE: No payment step is being collected at registration right now
        // (client decision). Registration is simply free/instant. If a paid
        // registration flow comes back later, add the payment fields +
        // validation here and decide what payment_status a new user should
        // start with.
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => 'avatar.png',
            'role' => 'customer',
            'status' => '1',
        ]);

        return redirect()->route('customer.login')->with('success', 'Account created successfully — please login.');
    } // End Method

    /* ===== Dashboard ===== */
    public function dashboard()
    {
        $customer = Auth::guard('user')->user();

        $todayCount = Download::where('user_id', $customer->id)
            ->whereDate('download_date', now()->toDateString())
            ->count();
        $limit = \App\Http\Controllers\DownloadController::DAILY_LIMIT;
        $remaining = max(0, $limit - $todayCount);

        $totalProducts = Product::where('status', 'active')->count();
        $totalDownloads = Download::where('user_id', $customer->id)->count();
        $recentDownloads = Download::with('product')
            ->where('user_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.customer.index', compact(
            'customer', 'remaining', 'limit', 'totalProducts', 'totalDownloads', 'recentDownloads'
        ));
    } // End Method

    /* ===== Profile Page ===== */
    public function profile()
    {
        $customer = Auth::guard('user')->user();
        $totalDownloads = Download::where('user_id', $customer->id)->count();
        return view('frontend.customer.pages.profile', compact('customer', 'totalDownloads'));
    } // End Method

    /* ===== Download History ===== */
    public function downloads()
    {
        $customer = Auth::guard('user')->user();

        $todayCount = Download::where('user_id', $customer->id)
            ->whereDate('download_date', now()->toDateString())
            ->count();
        $limit = \App\Http\Controllers\DownloadController::DAILY_LIMIT;
        $remaining = max(0, $limit - $todayCount);

        $downloads = Download::with('product')
            ->where('user_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('frontend.customer.pages.downloads', compact('downloads', 'remaining', 'limit'));
    } // End Method

    /* ===== Update Profile ===== */
    public function profileUpdate(Request $request)
    {
        $id = Auth::guard('user')->id();

        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $old_photo_path = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $file_name = uniqid('customer_', true) . '.' . $file->getClientOriginalExtension();
            $img = $manager->read($file->getRealPath());
            $img->resize(300, 300);

            $destination = public_path('upload/customer_images');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $img->save($destination . '/' . $file_name);
            $data->photo = $file_name;

            if ($old_photo_path && $old_photo_path !== $file_name) {
                $this->DeleteOldImage($old_photo_path);
            }
        }

        $data->save();

        $notification = [
            'message' => 'Customer Profile Updated Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    private function DeleteOldImage(string $old_photo_path): void
    {
        $full_path = public_path('upload/customer_images/' . $old_photo_path);

        if (file_exists($full_path)) {
            unlink($full_path);
        }
    } // End Private Method

    /* ===== Change Password ===== */
    public function changePassword(Request $request)
    {
        $customer = Auth::guard('user')->user();

        if (!$customer) {
            return back()->with([
                'message' => 'Unauthorized access!',
                'alert-type' => 'error',
            ]);
        }

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($request->old_password, $customer->password)) {
            return back()->with([
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error',
            ]);
        }

        $customer->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with([
            'message' => 'Password changed successfully!',
            'alert-type' => 'success',
        ]);
    }

    /* ===== Payment (post-registration, unlocks downloads) ===== */
    public function payment()
    {
        $customer = Auth::guard('user')->user();
        $site_settings_info = SiteSettings::first();
        return view('frontend.customer.pages.payment', compact('customer', 'site_settings_info'));
    } // End Method

    // NOTE: Manual "type your TrxID yourself" flow removed.
    // Payment now goes through BkashDemoController (simulated bKash gateway).

    /* ===== Logout ===== */
    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('customer.login')->with('success', 'Logged out successfully');
    }

    public function forgotPassword()
    {
        return view('frontend.customer.auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Try to find the user – no exception thrown
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Email not found – show a friendly error
            return back()
                ->withErrors(['email' => 'We can’t find an account with that e‑mail address.'])
                ->withInput();
        }

        // Create a token
        $token = Password::broker('users')->createToken($user);

        // Build the reset link (token + email)
        $link = route('password.reset', ['token' => $token, 'email' => $user->email]);

        // Send the mail
        Mail::to($user->email)->send(new CustomerResetMail($link));

        return back()->with('status', 'Reset link sent to your email.');
    }

    public function showResetForm(Request $request, $token)
    {
        // Pass the e‑mail from query string
        return view('frontend.customer.auth.reset', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::broker('users')->reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
        });

        return $status === Password::PASSWORD_RESET ? redirect()->route('customer.login')->with('success', 'Password reset.') : back()->withErrors(['email' => __($status)]);
    }
}