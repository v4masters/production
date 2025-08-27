<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use PaytmWallet;
use App\Models\API\Paytm;
use App\Models\API\OrderPaymentIcici;
use App\Models\API\Users;
use App\Models\API\VendorModel;
use App\Models\API\OrdersModel;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderPlacedMailVendor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
class PaytmController extends Controller
{
   public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    function aes128Encrypt($plaintext,$key) {
        $cipher = "AES-128-ECB";
        in_array($cipher, openssl_get_cipher_methods(true));
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes(1);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, "");
        //return $ciphertext."n";
        return $ciphertext;   
    }
    
   
   

    public function initiate()

    {
          return view('paytm');
    }


    
    public function pay(Request $request)
    {
        $user = Users::where('unique_id',$request->user_id)->first();
        $Orders = OrdersModel::select('grand_total','vendor_id')->where('invoice_number',$request->order_id)->first();
        if($user->email==NULL){$email='evyapari@hotmail.com';}else{$email=$user->email;}
        $userData = [
            'user_id'=>$user->unique_id,
            'name' => $user->name, // Name of user
            'mobile' => $user->phone_no, //Mobile number of user
            'email' => $email, //Email of user
            'amount' => $request->total_amount,
            'order_id' => $request->order_id, //Order id
        ];
        
        
        $orderexist= Paytm::where('order_id',$request->order_id)->first();
        if($orderexist==false)
        {
            
         Paytm::create($userData); // creates a new database record
        }
        
        // if($Orders->vendor_id=='G0RFC6VUJ28')
        // {
             
        //     $merchant_id = "388831";
        //     $key = "3807362088305001";
        //     $ref_no =$request->order_id;
        //     $sub_mer_id = "1";
        //     $amt = $request->total_amount;
        //     $return_url = "https://evyapari.com/admin/public/api/payment-response";
        //     $paymode = "9";
        //     $man_fields = $ref_no."|".$sub_mer_id."|".$amt."|".$user->name."|".$user->phone_no;
        //     $opt_fields = "";
        //     $e_sub_mer_id = $this->aes128Encrypt($sub_mer_id, $key);
        //     $e_ref_no = $this->aes128Encrypt($ref_no, $key);
        //     $e_amt = $this->aes128Encrypt($amt, $key);
        //     $e_return_url = $this->aes128Encrypt($return_url, $key);
        //     $e_paymode = $this->aes128Encrypt($paymode, $key);
        //     $e_man_fields = $this->aes128Encrypt($man_fields, $key);
        //     $e_opt_fields = $this->aes128Encrypt($opt_fields, $key);
                
        //     //Construct the encrypted URL
        //     $encrypted_url = "https://eazypay.icicibank.com/EazyPG?merchantid=$merchant_id&mandatory fields=$e_man_fields&optional fields=$e_opt_fields&returnurl=$e_return_url&Reference No=$e_ref_no&submerchantid=$e_sub_mer_id&transaction amount=$e_amt&paymode=$e_paymode";
        //     return redirect()->to($encrypted_url);
        //     // echo $man_fields;
            
            
        // }
        // else
        // {
            $payment = PaytmWallet::with('receive');
            $payment->prepare([
                'order' => $userData['order_id'], 
                'user' => 'uid-'.$userData['user_id'].' vid-'.$Orders->vendor_id, 
                'mobile_number' => $userData['mobile'],
                'email' => $email, // your user email address
                'amount' => $userData['amount'], // amount will be paid in INR.
                'callback_url' => url('/api/payment/status')// callback URL
            ]);
            return $payment->receive();  // initiate a new payment
        // }
     
    }
    
    
    
    
    public function codOrder(Request $request)
    {
        $user = Users::where('unique_id',$request->user_id)->first();
        if($user->email==NULL){$email='evyapari@hotmail.com';}else{$email=$user->email;}
        $userData = [
            'user_id'=>$user->unique_id,
            'name' => $user->name, // Name of user
            'mobile' => $user->phone_no, //Mobile number of user
            'email' => $email, //Email of user
            'amount' => $request->total_amount,
            'order_id' => $request->order_id, //Order id
            'status'=>1,
            'pay_mode'=>'COD',
            'band_txn_id'=>'BANKTXNID',
            'check_sum_hash'=>'CHECKSUMHASH',
            'transaction_amount'=>$request->total_amount,
            'transaction_id'=>'COD',
            'transaction_date'=>date('Y-m-d H:i:s'),
            'transaction_status'=>'TXN_SUCCESS',
        ];
        

        $orderexist= Paytm::where('order_id',$request->order_id)->first();
        if($orderexist==false)
        {
             Paytm::create($userData); // creates a new database record
             OrdersModel::where('invoice_number', $request->order_id)->update(['order_status' => 2, 'payment_status'=>2]);
         
             $this->sendsmsandmail($request->order_id);
             return redirect()->away('https://evyapari.com/paymentstatus/'.$request->order_id);
        
         
        }
        
        
    }
    
    
    
    

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId(); // return a order id


        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            OrdersModel::where('invoice_number', $order_id)->update(['order_status' => 2, 'payment_status'=>2]);
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'pay_mode'=>$response['PAYMENTMODE'],'band_txn_id'=>$response['BANKTXNID'],'check_sum_hash'=>$response['CHECKSUMHASH'],'transaction_amount'=>$response['TXNAMOUNT'],'transaction_id'=>$response['TXNID'],'transaction_date'=>$response['TXNDATE'],'transaction_status'=>$response['STATUS']]);
            $this->sendsmsandmail($order_id);
              
            return redirect()->away('https://evyapari.com/paymentstatus/'.$order_id);
     
        } else if ($transaction->isFailed()) {
            Paytm::where('order_id', $order_id)->update(['status' => 0, 'band_txn_id'=>$response['BANKTXNID'],'check_sum_hash'=>$response['CHECKSUMHASH'],'transaction_amount'=>$response['TXNAMOUNT'],'transaction_status'=>$response['STATUS']]);
            OrdersModel::where('invoice_number', $order_id)->update(['payment_status'=>3]);
            
             return redirect()->away('https://evyapari.com/paymentstatus/'.$order_id);
               
        } else if ($transaction->isOpen()) {
            Paytm::where('order_id', $order_id)->update(['status' => 2, 'pay_mode'=>$response['PAYMENTMODE'],'band_txn_id'=>$response['BANKTXNID'],'check_sum_hash'=>$response['CHECKSUMHASH'],'transaction_amount'=>$response['TXNAMOUNT'],'transaction_id'=>$response['TXNID'],'transaction_date'=>$response['TXNDATE'],'transaction_status'=>$response['STATUS']]);
            OrdersModel::where('invoice_number', $order_id)->update(['order_status'=>0,'payment_status'=>0]);
             
            return redirect()->away('https://evyapari.com/paymentstatus/'.$order_id);
           
              }
    }
    
//IciciHandleResponse
public function IciciHandleResponse(Request $request)
{
        $order_id=$request->ReferenceNo;
        if ($request->Response_Code=='E000') {
            
            $carbonDate = Carbon::createFromFormat('d-m-Y H:i:s', $request->Transaction_Date);
            $formattedDate = $carbonDate->format('Y-m-d H:i:s');
    
            $responsedata=[
            'response_code'=>$request->Response_Code,
            'unique_ref_number'=>$request->Unique_Ref_Number,
            'service_tax_amount'=>$request->Service_Tax_Amount,
            'processing_fee_amount'=>$request->Processing_Fee_Amount,
            'total_amount'=>$request->Total_Amount,
            'transaction_amount'=>$request->Transaction_Amount,
            'transaction_date'=>$formattedDate,
            'interchange_value'=>$request->Interchange_Value,
            'tdr'=>$request->TDR,
            'payment_mode'=>$request->Payment_Mode,
            'submerchantid'=>$request->SubMerchantId,
            'order_id'=>$request->ReferenceNo,
            'uid'=>$request->ID,
            'rs'=>$request->RS,
            'tps'=>$request->TPS,
            'mandatory_fields'=>$request->mandatory_fields,
            'optional_fields'=>$request->optional_fields,
            'rsv'=>$request->RSV
            ];
            
            OrderPaymentIcici::insert($responsedata);
            
 
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'pay_mode'=>$request->Payment_Mode,'band_txn_id'=>$request->ID,'check_sum_hash'=>$request->RSV,'transaction_amount'=>$request->Transaction_Amount,'transaction_id'=>$request->Unique_Ref_Number,'transaction_date'=>$formattedDate,'transaction_status'=>'TXN_SUCCESS']);
            OrdersModel::where('invoice_number', $order_id)->update(['order_status' => 2, 'payment_status'=>2]);
           
            $this->sendsmsandmail($order_id);
            return redirect()->away('https://evyapari.com/paymentstatus/'.$order_id);
     
        } 
        else
        {
           Paytm::where('order_id', $order_id)->update(['status' => 0, 'pay_mode'=>$request->Payment_Mode,'band_txn_id'=>$request->ID,'check_sum_hash'=>$request->RSV,'transaction_amount'=>$request->Transaction_Amount,'transaction_id'=>$request->Unique_Ref_Number,'transaction_date'=>date('Y-m-d H:i:s'),'transaction_status'=>'TXN_FAILURE']);
           OrdersModel::where('invoice_number', $order_id)->update(['payment_status'=>3]);
           return redirect()->away('https://evyapari.com/paymentstatus/'.$order_id);
        } 
}
    
      
  function sendsmsandmail($order_id)
    {
        
        $getuservenid=OrdersModel::select('user_id','vendor_id','grand_total')->where('invoice_number', $order_id)->first();
        if($getuservenid)
        {
            $user = Users::select('name','email')->where('unique_id',$getuservenid->user_id)->first();
           //sms to vendor
          $allvendors=explode(",",$getuservenid->vendor_id);
          foreach($allvendors as $vendorid)
          {
           
            $vendor= VendorModel::select('username','email','phone_no')->where('unique_id',$vendorid)->first();

        // 	$phone="91".$vendor->phone_no;
        // 	$venname=$vendor->username;
        
        //     $msgdata = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear vendor $venname you have received an order from demon on www.evyapari.com with order ID $order_id. Please check your vendor account for more detail about order. Regards, Evyapari.com";
        // 	$ch = curl_init('https://api.textlocal.in/send/?');
        // 	curl_setopt($ch, CURLOPT_POST, true);
        // 	curl_setopt($ch, CURLOPT_POSTFIELDS, $msgdata);
        // 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 	curl_exec($ch); 
        //     curl_close($ch);
			 
    	    
    	     $maildataven=["name"=>$vendor->username,"ordernumber"=>$order_id,"user_name"=>$user->name];
             Mail::to($vendor->email)->send(new OrderPlacedMailVendor($maildataven));
            }
            
             $maildata=["name"=>$user->name,"ordernumber"=>$order_id,"total_amount"=>$getuservenid->grand_total];
             Mail::to($user->email)->send(new OrderPlacedMail($maildata));
             
          

      
        }
	
    }



}