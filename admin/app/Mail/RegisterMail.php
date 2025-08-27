<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Welcome to Evyapari - Registration Successful!';  
    public $data;  

    public function __construct($data)
    {
        $this->data = $data;  
    }

    public function build()
    {
        return $this->view('emailtemp.register_temp')  
                      ->with([
                    'name' => $this->data['name'],  
                ]);
    }
}
