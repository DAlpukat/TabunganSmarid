<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuggestionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // biar data bisa dipakai di blade

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Kotak Saran Baru')
                    ->view('emails.suggestion') // 👈 Laravel bakal cari di resources/views/emails/suggestion.blade.php
                    ->with('data', $this->data);
    }
}   