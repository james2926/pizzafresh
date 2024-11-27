<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable  implements ShouldQueue
{
    use  SerializesModels;

    public $email;

    public $token;

    public function __construct($email, $token){
        $this->email = $email;
        $this->token = $token;
    }

    public function build(){
        return $this->markdown('email.user.forgot-password', ['email' => $this->email, 'token' => $this->token])->subject('Recuperar Contraseña');
    }
}
