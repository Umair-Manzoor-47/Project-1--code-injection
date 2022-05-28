<?php
$plaintext="cyber";
$key=hash('sha256', 'mobileWebProgramming', true);
$key_base64=base64_encode($key);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
print "iv_size=$iv_size<br />\n";
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$iv_base64=base64_encode($iv);
$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                 $plaintext, MCRYPT_MODE_CBC, $iv);
print "iv_base64=$iv_base64<br />key_base64=$key_base64<br />plaintext=$plaintext<br />\n";
# prepend the IV for it to be available for decryption
$ciphertext = $iv . $ciphertext;
$ciphertext_base64 = base64_encode($ciphertext);
echo  'ciphertext_base64='. $ciphertext_base64 . "\n";
// decrypt process
$ciphertext_dec = base64_decode($ciphertext_base64);
# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
$iv_dec = substr($ciphertext_dec, 0, $iv_size);

#retrieves the cipher text (everything except the $iv_size in the front)
$ciphertext_dec = substr($ciphertext_dec, $iv_size);
$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    
echo  'plaintext_decrypted='. $plaintext_dec . "\n";



?>
