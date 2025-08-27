<?php
function encryptDataa($plaintext, $key, $iv) {
    // Ensure key and IV are exactly 16 bytes
    if (strlen($key) !== 16) {
        die("Error: Key must be 16 bytes.");
    }
    if (strlen($iv) !== 16) {
        die("Error: IV must be 16 bytes.");
    }

    // Encrypt using AES-128-CBC
    $encryptedData = openssl_encrypt($plaintext, 'AES-128-ECB', $key, OPENSSL_RAW_DATA, $iv);

    // Encode in Base64
    return base64_encode($encryptedData);
}

function test_pay() {
    // Input URL
    $plaintext = "https://evyapari.com/payment-response";

    // Secret Key (Must be 16 bytes for AES-128)
    $secretKey = "1400011017205020";  

    // Initialization Vector (IV) - Try this IV first
    $iv = "1234567890123456";  

    // Encrypt
    $encryptedText = encryptDataa($plaintext, $secretKey, $iv);

    // Output the result
    echo $encryptedText . "<br>";
    echo "vnAabxSVySqxLf+kVZRHJDwoBJ0P7F4QxpcUpZw+0s4tJJuf9NX8ijHof/uJ31P+<br>";

    // Debugging - Print IV in Base64 format
    echo "IV in Base64: " . base64_encode($iv) . "<br>";
}

// Run the function
test_pay();
?>
