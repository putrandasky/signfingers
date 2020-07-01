<?php

namespace App\Http\Controllers\Inbox;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, $locale = '')
    {
        $rules = [
            'title' => 'required|min:10',
            'messages' => 'required|min:10',
            'ip_address' => 'required',
            'email' => 'required|email',
        ];
        if ($locale == 'id') {
            $messages_validator = [
                'title.required' => 'Judul diperlukan',
                'title.min' => 'Judul minimum 10 huruf',
                'email.required' => 'Alamat email anda diperlukan',
                'email.email' => 'Mohon masukan alamat email anda dengan benar',
                'messages.required' => 'Isi pesan diperlukan',
                'messages.min' => 'Isi pesan minimum 10 huruf',
                'ip_address.required' => 'Ip address anda diperlukan',
            ];
            $messages_respond = 'Pesan anda sudah tersimpan';
        } else {
            $messages_validator = [
                'title.required' => 'The title is required',
                'title.min' => 'The title must have 10 words as minimum',
                'messages.required' => 'The messages is required',
                'messages.min' => 'The messages must have 10 words as minimum',
                'email.required' => 'Your email address is required',
                'email.email' => 'Please input your correct email address',
                'ip_address.required' => 'Your ip address is required',
            ];
            $messages_respond = 'Your message has been recorded';
        }
        $this->validate($request, $rules, $messages_validator);

        $feedback = App\Message::create([
            'title' => $request->title,
            'messages' => $request->messages,
            'ip_address' => $request->ip_address,
            'email' => $request->email,
        ]);
        return response()->json(['message' => $messages_respond], 200);
    }

}
