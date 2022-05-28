<?php
$ciphertext_base64=file_get_contents("ivcipher_base64.dat");
$ciphertext_dec = base64_decode($ciphertext_base64);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
$iv_dec = substr($ciphertext_dec, 0, $iv_size);
$key=hash('sha256', 'mobileWebProgramming', true);
#retrieves the cipher text (everything except the $iv_size in the front)
$ciphertext_dec = substr($ciphertext_dec, $iv_size);
$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                            $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

file_put_contents("plaintext_dec.dat", $plaintext_dec);
?>
