<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactFormController extends Controller
{
    public function ContactSubmit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'contact_form_name' => 'required|string|max:255',
                'contact_form_email' => 'required|email|max:255',
                'contact_form_phone' => 'nullable|string|max:20',
                'contact_form_subject' => 'required|string|max:255',
                'contact_form_message' => 'required|string',
            ],
            [
                'contact_form_name.required' => 'Name is required.',
                'contact_form_email.required' => 'Email is required.',
                'contact_form_email.email' => 'Please enter a valid email address.',
                'contact_form_subject.required' => 'Subject is required.',
                'contact_form_message.required' => 'Message is required.',
                'contact_form_message.string' => 'Message must be a string.',
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $contactForm = new ContactForm();
            $contactForm->contact_form_name = $request->contact_form_name;
            $contactForm->contact_form_email = $request->contact_form_email;
            $contactForm->contact_form_phone = $request->contact_form_phone;
            $contactForm->contact_form_subject = $request->contact_form_subject;
            $contactForm->contact_form_message = $request->contact_form_message;
            $contactForm->save();

            return redirect()
                ->back()
                ->with('success', 'Message submitted successfully!');
        } catch (\Throwable $e) {
            Log::error('Error submitting contact form: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit. Please try again.');
        }
    } // End Method

    public function ContactFormList()
    {
        $contact_form_list = ContactForm::orderBy('id', 'asc')->get();
        return view('backend.contact_form.list', compact('contact_form_list'));
    } // End Method

    public function ContactFormDelete($id)
    {
        try {
            DB::beginTransaction();

            $contact_form_data = ContactForm::findOrFail($id);

            $contact_form_data->delete();

            DB::commit();

            return redirect()
                ->route('backend.contact_form.list')
                ->with([
                    'message' => 'Contact Form deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Contact Form: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Contact Form.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ContactFormBulkDelete(Request $request)
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

            ContactForm::whereIn('id', $ids)->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Selected contact forms deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error bulk deleting contact forms: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete selected contact forms.',
                    'alert-type' => 'error',
                ]);
        }
    }
}