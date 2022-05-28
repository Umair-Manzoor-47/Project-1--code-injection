<?php 
$data = file_get_contents("plain.txt"); 
// fetch public key of the sender from certificate file and ready it 
$cert=file_get_contents("cs591Cert.pem"); 
$pub_key = openssl_pkey_get_public($cert); 
$signature=file_get_contents("signature.dat"); 
$r=openssl_verify($data, $signature, $pub_key, "sha256WithRSAEncryption"); 
var_dump($r); 
?>

