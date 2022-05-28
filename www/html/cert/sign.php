<?php 
$data = file_get_contents("plain.txt"); 
// fetch private key from file and ready it 
$pkeyid = openssl_pkey_get_private("file://cs591UnencKey.pem"); openssl_sign($data, $signature, $pkeyid, OPENSSL_ALGO_SHA256); openssl_free_key($pkeyid); // shorten memory leak vulnerability
file_put_contents("signature.dat", $signature); 
?>

