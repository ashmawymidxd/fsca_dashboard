<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewContactSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('pages.contacts.index', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20|regex:/^[\d\s\-\+\(\)]{10,20}$/',
            'service_type' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'phone.required' => 'The phone number is required.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'phone.regex' => 'Please enter a valid phone number.',
            'service_type.required' => 'The service type is required.',
            'service_type.max' => 'The service type may not be greater than 255 characters.',
            'message.required' => 'The message field is required.',
            'message.min' => 'The message must be at least 10 characters.',
            'message.max' => 'The message may not be greater than 1000 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
                'data' => null
            ], 422);
        }

        try {
            $contact = Contact::create($request->only([
                'name', 'email', 'phone', 'service_type', 'message'
            ]));

            // Send notification to auth user
            $adminUsers = User::get();
            foreach ($adminUsers as $user) {
                $user->notify(new NewContactSubmission($contact));
            }

            return response()->json([
                'success' => true,
                'message' => 'Contact message submitted successfully',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create contact',
                'errors' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('pages.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
   public function destroy(Contact $contact)
    {
        // Delete all notifications related to this contact
        DB::table('notifications')
            ->where('type', NewContactSubmission::class)
            ->whereJsonContains('data->contact_id', $contact->id)
            ->delete();

        // Delete the contact message
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
    }

    /**
     * Send reply to contact
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function sendReply(Request $request, Contact $contact)
    {
        $request->validate([
            'reply_message' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Send email
        Mail::to($contact->email)->send(new ContactReplyMail($contact, $request->reply_message));

        // Update contact status
        $contact->update([
            'status' => 'replied',
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully');
    }
}
