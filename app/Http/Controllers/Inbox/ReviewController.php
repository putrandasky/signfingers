<?php

namespace App\Http\Controllers\Inbox;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $locale = '')
    {
        $rules = [
            'messages' => 'required|min:10',
            'rating' => 'required|integer',
        ];
        if ($locale == 'id') {
            $messages_validator = [
                'messages.required' => 'Isi pesan diperlukan',
                'messages.min' => 'Isi pesan minimum 10 huruf',
                'rating.required' => 'Rating anda diperlukan',
                'rating.integer' => 'Rating harus berupa angka',
            ];
            $messages_respond = 'Review anda sudah tersimpan';
        } else {
            $messages_validator = [
                'messages.required' => 'The messages is required',
                'messages.min' => 'The messages must have 10 words as minimum',
                'rating.required' => 'Your rating is required',
                'rating.integer' => 'The rating must be in number',
            ];
            $messages_respond = 'Your review has been recorded';
        }
        $this->validate($request, $rules, $messages_validator);

        $feedback = App\Review::create([
            'messages' => $request->messages,
            'rating' => $request->rating,
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
        ]);
        return response()->json(['message' => $messages_respond], 200);
    }
}
