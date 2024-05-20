<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class MessageController extends ParentController
{
    public function __construct()
    {
        $this->model = Message::class;
        $this->model_name = 'Message';
        $this->middleware('auth:sanctum');
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
        if ($data['receiver_id'] == Auth::user()->id) {
            return ['error' => ['message' => ['Vous ne pouvez pas vous envoyer un message vers vous meme']]];
        }
        return $data;
    }
    public function afterSaveForStore($new_model)
    {
        return 'Message Sent';
    }
    public function getMessages($id)
    {
        $messages = $this->model->where('sender_id', $id)->where('receiver_id', '=', Auth::user()->id)->get();
        foreach ($messages as $message) {
            $message->update(['is_read' => true]);
        }
        return $this->model->where('receiver_id', $id)->where('sender_id', '=', Auth::user()->id)->orWhere('sender_id', $id)->where('receiver_id', '=', Auth::user()->id)->get();
    }
    public function index()
    {
        return;
    }
    public function indexPaginate()
    {
        return;
    }
    public function show($id)
    {
        return;
    }
}
