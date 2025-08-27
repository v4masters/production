<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Good News! Your Order Has Been Shipped"';  
    public $data;  

    public function __construct($data)
    {
        $this->data = $data;  
    }

    public function build()
    {
        return $this->view('emailtemp.order_shipped')  
                      ->with([
                     'name' => $this->data['name'],  
                    'ordernumber'=>$this->data['ordernumber'], 
                    'orderitems'=>$this->data['orderitems'],  
                ]);
    }
}
