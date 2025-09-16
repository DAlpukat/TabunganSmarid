<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuggestionMail;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'message' => 'required|string',
        ]);

        // Kirim ke email kamu
        Mail::to('robetsihotangdaniel@gmail.com')->send(new SuggestionMail($data));

        return back()->with('success', 'Saran berhasil dikirim!');
    }
}