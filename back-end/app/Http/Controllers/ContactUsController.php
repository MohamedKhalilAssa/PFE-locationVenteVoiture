<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends ParentController
{
    public function __construct()
    {
        $this->model = ContactUs::class;
        $this->model_name = 'Contact';
        $this->middleware('auth:sanctum');
        $this->middleware('admin')->except(['store']);
        parent::__construct();
    }

    public function beforeValidateForStore()
    {
        $this->rules = [
            'full_name' => ['required', 'min:3', 'string', 'regex:/^\D*$/', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'object' => ['required', 'min:3', 'string', 'max:255'],
            'message' => ['required', 'min:10', 'string', 'max:1024'],
        ];
    }
    public function beforeSaveForStore()
    {
        $data = array_merge($this->request->all(), ['user_id' => Auth::user()->id]);
        return $data;
    }
    public function answer($id)
    {
        $contact = ContactUs::find($id);

        $this->request->validate([
            'answer' => 'required|string|min:10|max:1024',
        ]);

        $email = $contact->email;
        $messageContent = $this->request->input('answer');

        Mail::to($email)->send(new ContactFormMail($email, $messageContent));

        $contact->update(['is_answered' => true]);
        return response()->json(['message' => 'Email sent successfully!']);
    }
}
