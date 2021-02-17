<?php

namespace App\Http\Controllers\Inbox;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, $locale = '')
    {
        $rules = [
            'messages' => 'required|min:10',
        ];
        if ($locale == 'id') {
            $messages_validator = [
                'messages.required' => 'Isi pesan diperlukan',
                'messages.min' => 'Isi pesan minimum 10 huruf',

            ];
            $messages_respond = 'Feedback anda sudah tersimpan';
        } else {
            $messages_validator = [
                'messages.required' => 'The messages is required',
                'messages.min' => 'The messages must have 10 words as minimum',

            ];
            $messages_respond = 'Your feedback has been recorded';
        }
        $this->validate($request, $rules, $messages_validator);

        $feedback = App\Feedback::create([
            'messages' => $request->messages,
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
        ]);
        return response()->json(['message' => $messages_respond], 200);
    }
}
