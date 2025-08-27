<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Your Order Has Been Placed Successfully!';  
    public $data;  

    public function __construct($data)
    {
        $this->data = $data;  
    }

    public function build()
    {
        return $this->view('emailtemp.order_placed')  
                      ->with([
                     'name' => $this->data['name'],  
                    'ordernumber'=>$this->data['ordernumber'], 
                    'total_amount'=>$this->data['total_amount'],  
                ]);
    }
}
