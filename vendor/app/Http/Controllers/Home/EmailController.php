<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $data = ['name' => 'John Doe'];
        Mail::to('kiranpjc7@gmail.com')->send(new RegisterMail($data));
        return 'Email sent successfully';
    }
}

