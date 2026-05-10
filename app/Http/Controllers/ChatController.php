<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function users()
    {
        // If user is admin, show all other users
        if(auth()->user()->is_admin()) {
            return User::where('id', '!=', auth()->id())->get();
        }
        
        // If user is customer, show only admins
        return User::where('role', 'admin')->get();
    }

    public function messages($id)
    {
        return Message::where(function($q) use ($id) {

            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $id);

        })->orWhere(function($q) use ($id) {

            $q->where('sender_id', $id)
              ->where('receiver_id', auth()->id());

        })->orderBy('id')->get();
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id|different:sender_id',
            'message' => 'required|string',
        ], [
            'receiver_id.required' => 'Receiver is required',
            'receiver_id.exists' => 'User not found',
            'message.required' => 'Message cannot be empty',
        ]);

        $validated['sender_id'] = auth()->id();

        $message = Message::create($validated);

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }
}
