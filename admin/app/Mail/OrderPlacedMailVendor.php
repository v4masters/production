<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMailVendor extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'New Order Received from Evyapari!';  
    public $data;  

    public function __construct($data)
    {
        $this->data = $data;  
    }

    public function build()
    {
        return $this->view('emailtemp.order_recived')  
                      ->with([
                     'name' => $this->data['name'],  
                    'ordernumber'=>$this->data['ordernumber'], 
                    'user_name'=>$this->data['user_name'],  
                ]);
    }
}
