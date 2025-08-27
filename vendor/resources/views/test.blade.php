<?php

function aes128Encrypt($plaintext,$key){

    $cipher = "AES-128-ECB";

    in_array($cipher, openssl_get_cipher_methods(true));

    $ivlen = openssl_cipher_iv_length($cipher);

    $iv = openssl_random_pseudo_bytes(1);

    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, "");

    //return $ciphertext."n";

    return $ciphertext;   

    }

    $merchant_id = "388831";

    $key = "3807362088305001";

    $ref_no = "2025032111012222124948";

    $sub_mer_id = "1";

    $amt = "4666";

    $return_url = "https://evyapari.com/admin/public/api/payment-response"; //"https://eazypay.icicibank.com/OTCPgResP/EZYPGPay";

    $paymode = "9";

    $man_fields = $ref_no."|".$sub_mer_id."|".$amt."|kiran gumra|6239961199";

    $opt_fields = "";

    $e_sub_mer_id = aes128Encrypt($sub_mer_id, $key);

    $e_ref_no = aes128Encrypt($ref_no, $key);

    $e_amt = aes128Encrypt($amt, $key);

    $e_return_url = aes128Encrypt($return_url, $key);

    $e_paymode = aes128Encrypt($paymode, $key);

    $e_man_fields = aes128Encrypt($man_fields, $key);

    $e_opt_fields = aes128Encrypt($opt_fields, $key);


    ?>
<center>
<h1>ICICI PG (Testing Page)</h1>
 
    <html>
<head>
<style>

body {background-color: rgba(201, 76, 76, 0.3);}
 
</style>
</head>
<body>
 
 
    
<p>

    *Welcome*
<br><br>

    Initiate testing <b> </b>
</p>
<p>
<a href="https://eazypay.icicibank.com/EazyPG?merchantid=388831&mandatory fields=Oimpns4+wIBddCRCwda8S6wVqXgUtpw599LeC6aoPc/96l1872CHyGgHrBfaTC3S&optional fields=rVRJaq1zD/4pcuTLNvhuVQ==&returnurl=DPrtt5QjqzZ63qgRmUa1et1fo4O6NCGKNRSYZBiu8essmfwglI7uJ4lMN+Z4nSBIcAoit1Z97aUP7UVbb36wlg==&Reference No=Oimpns4+wIBddCRCwda8S0SWLTvdyrbI8bqxLfdqaVE=&submerchantid=6Lau3Pl7qoHzesfRwbTB+Q==&transaction amount=zefFa1rtWD8pEm3FGTkA/g==&paymode=c6l/D8F/buxkryjGkDH1KA==" target="_blank" >pay</a>    
<a href="https://eazypay.icicibank.com/EazyPG?merchantid=<?=$merchant_id?>&mandatory fields=<?=$e_man_fields?>&optional fields=<?=$e_opt_fields?>&returnurl=<?=$e_return_url?>&Reference No=<?=$e_ref_no?>&submerchantid=<?=$e_sub_mer_id?>&transaction amount=<?=$e_amt?>&paymode=<?=$e_paymode?>">Pay With ICICI</a>
</center>
<p style="max-width: 100%;">
<b><u>Pay Link (Before Encryption)</u>:</b><br>https://eazypay.icicibank.com/EazyPG?merchantid=<?=$merchant_id?>&mandatory fields=<?=$man_fields?>&optional fields=<?=$opt_fields?>&returnurl=<?=$return_url?>&Reference No=<?=$ref_no?>&submerchantid=<?=$sub_mer_id?>&transaction amount=<?=$amt?>&paymode=<?=$paymode?>
</p>
<p style="max-width: 100%;">
<b><u>Pay Link (After Encryption)</u>:</b><br><span style="max-width: 100%">https://eazypay.icicibank.com/EazyPG?merchantid=<?=$merchant_id?>&mandatory fields=<?=$e_man_fields?>&optional fields=<?=$e_opt_fields?>&returnurl=<?=$e_return_url?>&Reference No=<?=$e_ref_no?>&submerchantid=<?=$e_sub_mer_id?>&transaction amount=<?=$e_amt?>&paymode=<?=$e_paymode?><br></span>
 
 
 
 