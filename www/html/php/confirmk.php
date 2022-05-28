<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
foreach ($_REQUEST as $key => $value) {
   print "name=$key value=$value<br>";
}
$email=$_GET['email'];
$ciphertext_base64=$_GET['token'];

if (!preg_match("/^[a-zA-Z0-9.]+\@[a-zA-Z0-9.]+$/", $email)) {
   print "incorrent email format. </body></html>";
   exit(0);
}
print "ciphertext_base64=$ciphertext_base64<br />\n";
if (!preg_match("/^[a-zA-Z0-9\/+]+={0,2}$/", $ciphertext_base64)) {
   print "incorrent key format. </body></html>";
   exit(0);
}

// decrypt process 
$ciphertext_dec = base64_decode($ciphertext_base64);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
$iv_dec = substr($ciphertext_dec, 0, $iv_size);
$key=hash('sha256', 'mobileWebProgramming', true);
#retrieves the cipher text (everything except the $iv_size in the front)
$ciphertext_dec = substr($ciphertext_dec, $iv_size);
$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                            $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
$keystring=$email.'cyber';
$pl=strlen($plaintext_dec);
$kl=strlen($keystring);
$plaintext_nopad=substr($plaintext_dec, 0, $kl);
$pnl=strlen($plaintext_nopad);
print "pl=$pl; kl=$kl; pnl=$pnl<br />\n";
print "plaintext_nopad=$plaintext_nopad<br />keystring=$keystring<br />\n";
if (strcmp($keystring, $plaintext_nopad) == 0) {
   print "token matched!<br />";
} else {
   print "token does not match!. Registration is denied.< br />\n";
   exit(1);
}
print "keystring=$keystring; plaintext_nopad=$plaintext_nopad<br />\n";


$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$mysqli=new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}

if (!$result = $mysqli->query("SELECT password FROM member1 WHERE email='$email'")) {
   die('There was an error running the query [' . $mysqli->error . ']');
}
$row = $result->fetch_assoc();
$bp = $row['password'];
print "bp=$bp<br />\n";
if (substr($bp, 0, 1) == '-') {
      $password = substr($bp, 1, strlen($bp)-1);
      $password = '+'.$password;   //now wait for the manager to approve
} else {
   print "already confirmed<br />";
} 

#make sure the following query has , separate the two fields
#
$query="UPDATE member1 SET password='$password', status=0 where email='$email'";
if (!$mysqli->query($query)) {
         echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
         exit(1);
}

$domain=$_SERVER['HTTP_HOST'];

$msg="your registration is now waitig for manager approval.  Please use the following link to enter member only area. <a href=\"http://$domain/cyber/\">http://$domain/cyber/</a>.";
$to=$email;
$subject="cyber club registration completed";
$header="From: root@cs3110.cnset.uccs.edu\r\n" .
        "Mime-Version: 1.0\r\n" .
        "Content-type: text/html; charset=\"iso-8859-1\"\r\n\r\n"; 
mail($to, $subject, $msg, $header);
print $msg;

?>
</body>
</html>
