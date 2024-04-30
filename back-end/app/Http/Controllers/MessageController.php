<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends ParentController
{
    public function __construct()
    {
        $this->model = Message::class;
        $this->model_name = 'Message';
        parent::__construct();
    }
    public function beforeValidateForStore()
    {
        $this->rules = [
            'receiver_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string'],
        ];
    }

    public function beforeSaveForStore()
    {
        $data = $this->request->all();
        $data['sender_id'] = Auth::user()->id;
        return $data;
    }
}
