<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $user;

    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('🔐 Restablece tu contraseña en WorkScrum')
                ->view('pages.auth.reset')
                ->with([
            'user' => $this->user,
            'url'  => $this->url,
        ])
        ->withSwiftMessage(function ($message) {
            $logoPath = public_path('assets/images/logos/workscrum.png');
            $message->embed($logoPath);
        });
    }
}
