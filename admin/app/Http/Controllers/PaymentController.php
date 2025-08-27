<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Models\API\Paytm;
use App\Models\API\Users;
use App\Models\API\VendorModel;
use App\Models\API\OrdersModel;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;

use App\Mail\OrderPlacedMail;
use App\Mail\OrderPlacedMailVendor;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{
   
    public function test_pay()
    {
        return view('icici.ini_payment');
    }
    


function encryptData($plaintext) {
    return base64_encode(openssl_encrypt($plaintext, 'AES-128-ECB', "1400011017205020", OPENSSL_RAW_DATA));
}

function aes128Encrypt($str) {
        $iv = str_repeat("\0", 16);
        $encryptedData = openssl_encrypt($str, 'AES-128-CBC','1400011017205020', OPENSSL_RAW_DATA, $iv);
        return base64_encode($encryptedData);
}



function generateEncryptedUrl() {
    
    $iv = "1234567890123456"; 
    $orderid=date('YmdHis');
    // Plain values
    $plain_url = [
        'merchantid' => '141721',
        'mandatoryfields' => $orderid.'|11|100|Kiran|6239961199',
        'optionalfields' => '',
        'returnurl' => 'https://evyapari.com/admin/public/api/payment-response',
        'referenceno' => $orderid,
        'submerchantid' => '11',
        'transactionamount' => '100',
        'paymode' => '9',
    ];


    // Encrypt each field
    $encrypted_mandatory_fields = $this->encryptData($plain_url['mandatoryfields']);
    $encrypted_return_url = $this->encryptData($plain_url['returnurl']);
    $encrypted_referenceno = $this->aes128Encrypt($plain_url['referenceno']);
    $encrypted_submerchantid = $this->aes128Encrypt($plain_url['submerchantid']);
    $encrypted_transactionamount = $this->aes128Encrypt($plain_url['transactionamount']);
    $encrypted_paymode = $this->aes128Encrypt($plain_url['paymode']);

    // Construct the encrypted URL
    $encrypted_url = 'https://eazypayuat.icicibank.com/EazyPG?merchantid='.$plain_url['merchantid'].'&mandatory fields='.$encrypted_mandatory_fields.'&optional fields='.$plain_url['optionalfields'].'&returnurl='.$encrypted_return_url.'&Reference No='.$encrypted_referenceno.'&submerchantid='.$encrypted_submerchantid.'&transaction amount='.$encrypted_transactionamount.'&paymode='.$encrypted_paymode;
    return $encrypted_url;
}

    public function initiatePayment(Request $request)
    {
        $encrypted_url = $this->generateEncryptedUrl();
          return redirect()->to($encrypted_url);

    }
    
    public function handleResponse(Request $request)
    {
        $responseData = $request->all();
    
       print_r($responseData);
    }
    
    
    private function validateSignature($data)
    {
        $expectedSignature = hash('sha512', implode('|', [
            env('EAZYPAY_MERCHANT_ID'),
            $data['ResponseCode'],
            $data['UniqueRefNumber'],
            $data['TransactionAmount'],
        ]));
    
        return $expectedSignature === $data['RS'];
    }
    
    public function verifyTransaction($referenceNo)
    {
        $merchantId = env('EAZYPAY_MERCHANT_ID');
        $verifyUrl = "https://eazypay.icicibank.com/EazyPGVerify?merchantid={$merchantId}&pgreferenceno={$referenceNo}";
    
        $response = Http::get($verifyUrl);
        return response()->json($response->json());
    }

    public function initiateRefund($transactionId, $refundAmount)
    {
        $merchantId = env('EAZYPAY_MERCHANT_ID');
        $aesKey = env('EAZYPAY_AES_KEY');
    
        $jsonData = json_encode([
            'Paymode' => 'NET_BANKING',
            'TransactionID' => $transactionId,
            'TransactionDate' => now()->format('Y-m-d'),
            'MerchantId' => $merchantId,
            'RefundAmount' => $refundAmount,
            'Signature' => hash('sha512', "{$merchantId}|{$transactionId}|{$refundAmount}")
        ]);
    
        $encryptedData = encryptData($jsonData, $aesKey);
    
        $response = Http::withHeaders(['private_key' => 'your_private_key'])->post(
            "https://eazypay.icicibank.com/OnlineRefundService/rest/OnlineRefundService/OnlineRefundDetails",
            ['MerchantId' => $merchantId, 'inputdata' => $encryptedData]
        );
    
        return response()->json($response->json());
    }

}
