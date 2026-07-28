<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Mail\WebsiteMail;
use App\Models\Blog;
use App\Models\BulkOrder;
use App\Models\ContactForm;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function AdminLogin()
    {
        return view('admin.auth.login');
    } // End Method

    public function AdminDashboard()
    {
        $productCount = Product::count();
        $blogCount = Blog::count();
        $contactCount = ContactForm::count();
        $orderCount = Order::count();

        return view('admin.index', compact('productCount', 'blogCount', 'contactCount', 'orderCount'));
    }

    public function AdminLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();

        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin.dashboard')->with('success', 'Login Successfully');
        } else {
            return redirect()->route('admin.login')->with('error', 'Invalid Credentials');
        }
    } // End Method

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully');
    } // End Method

    public function AdminForgetPassword()
    {
        return view('admin.auth.forget_password');
    } // End Method

    public function AdminForgetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin_data = Admin::where('email', $request->email)->first();

        if (!$admin_data) {
            return redirect()->back()->with('error', 'Email Not Found');
        }

        $token = hash('sha256', time());
        $admin_data->token = $token;
        $admin_data->update();

        $reset_link = url('admin/reset/password/' . $token . '/' . $request->email);
        $subject = 'Reset Password';
        $message = 'Please Click on below link to reset password <br>';
        $message .= "<a href='" . $reset_link . "'> Click Here </a>";

        Mail::to($request->email)->send(new WebsiteMail($subject, $message));

        return redirect()->back()->with('success', 'Reset Password Link Send On Your Email');
    } // End Method

    public function AdminResetPassword($token, $email)
    {
        $admin_data = Admin::where('email', $email)->where('token', $token)->first();

        if (!$admin_data) {
            return redirect()->route('admin.login')->with('error', 'Invalid Token or Email');
        }

        return view('admin.auth.reset_password', compact('token', 'email'));
    } // End Method

    public function AdminResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin_data = Admin::where('email', $request->email)->where('token', $request->token)->first();
        $admin_data->password = Hash::make($request->password);
        $admin_data->token = '';
        $admin_data->update();

        return redirect()->route('admin.login')->with('success', 'Password Reset Successfully');
    } // End Method

    public function AdminProfile()
    {
        $id = Auth::guard('admin')->id();

        $profile_data = Admin::find($id);

        return view('admin.profile.admin_profile', compact('profile_data'));
    } // End Method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::guard('admin')->id();

        $data = Admin::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $old_photo_path = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $file_name = uniqid('admin_', true) . '.' . $file->getClientOriginalExtension();
            $img = $manager->read($file->getRealPath());
            $img->resize(80, 80);
            $img->save(public_path('upload/admin_images/') . $file_name);
            $data->photo = $file_name;

            if ($old_photo_path && $old_photo_path !== $file_name) {
                $this->DeleteOldImage($old_photo_path);
            }
        }

        $data->save();

        $notification = [
            'message' => 'Admin Profile Updated Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    private function DeleteOldImage(string $old_photo_path): void
    {
        $full_path = public_path('upload/admin_images/' . $old_photo_path);

        if (file_exists($full_path)) {
            unlink($full_path);
        }
    } // End Private Method

    public function AdminChangePassword()
    {
        $id = Auth::guard('admin')->id();

        $profile_data = Admin::find($id);

        return view('admin.profile.admin_change_password', compact('profile_data'));
    } // End Method

    public function AdminPasswordUpdate(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $admin->password)) {
            $notification = [
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error',
            ];
            return back()->with($notification);
        }

        Admin::whereId($admin->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notification = [
            'message' => 'Admin Password Change Successfully!',
            'alert-type' => 'success',
        ];
        return back()->with($notification);
    } // End Method
}
