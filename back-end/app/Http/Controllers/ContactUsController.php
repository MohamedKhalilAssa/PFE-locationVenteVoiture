<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
