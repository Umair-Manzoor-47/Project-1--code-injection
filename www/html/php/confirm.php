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
$key=$_GET['key'];

if (!preg_match("/^[a-zA-Z0-9.]+\@[a-zA-Z0-9.]+$/", $email)) {
   print "incorrent email format. </body></html>";
   exit(0);
}
if (!preg_match("/^[a-f0-9]{32}$/", $key)) {
   print "incorrent key format. </body></html>";
   exit(0);
}

$keystring=$email.'cyber';
$str=md5($keystring);
if ($str == $key) {
   print "key matched!<br />";
} else {
   print "problem with your key. Registration is denied.< br />\n";
   exit(1);
}
print "keystring=$keystring; str=$str<br />\n";


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

$msg="your registration is now waitig for manager to approve.  Please use the following link to enter member only area. <a href=\"http://$domain/sec/\">http://$domain/sec/</a>.";
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
