<?php
$plaintext=pack("H*", "00000000000000000000");
file_put_contents("plaintext.dat", $plaintext);
$key=hash('sha256', 'mobileWebProgramming', true);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_STREAM);
print "iv_size=$iv_size; ";
//$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                 // $plaintext, MCRYPT_MODE_CBC, $iv);
print "strlen(plaintext)=".strlen($plaintext)."; $plaintext<br />\n";
//print "strlen(ciphertex)=".strlen($ciphertext)."; $ciphertext<br />\n";
exit(1);
file_put_contents("ciphertext.dat", $ciphertext);
# prepend the IV for it to be available for decryption
$ivciphertext = $iv . $ciphertext;
$ivciphertext_base64 = base64_encode($ivciphertext);
print "strlen(ciphertext)=".strlen($ciphertext)."; $ciphertext<br />\n";
print "strlen(ivciphertext)=".strlen($ivciphertext)."; $ivciphertext<br />\n";
print "strlen(ivciphertext_base64)=".strlen($ivciphertext_base64)."; $ivciphertext_base64<br />\n";
file_put_contents("ivcipher.dat", $ivciphertext);
file_put_contents("ivcipher_base64.dat", $ivciphertext_base64);
?>
