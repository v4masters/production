<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderProcessMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Your Order is Being Processed';  
    public $data;  

    public function __construct($data)
    {
        $this->data = $data;  
    }

    public function build()
    {
        return $this->view('emailtemp.order_processing')  
                      ->with([
                    'name' => $this->data['name'],  
                    'ordernumber'=>$this->data['ordernumber'], 
                    'orderitems'=>$this->data['orderitems'], 
                ]);
    }
}
