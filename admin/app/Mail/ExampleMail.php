<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'e-Vyapari';  // Subject of the email

    public $data;  // You can pass data to the view

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;  // Data that you want to pass to the email view
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emailtemp.'.$this->data['template'])  // View file for the email body
                      ->with([
                    'name' => $this->data['name'],  // Assuming $this->data is an associative array
                    // 'message' => $this->data['message'],
                ]);
    }
}
