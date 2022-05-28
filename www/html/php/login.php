<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
foreach ($_REQUEST as $key => $value) {
   print "name=$key value=$value<br>";
}
//extract($_REQUEST);
$email=$_POST['email'];
$emailConfirmed=$_POST['emailConfirmed'];
$password=$_POST['password'];
$groups=$_POST['groups'];
$passwordConfirmed=$_POST['passwordConfirmed'];
//$fullName=$_POST['fullName'];
//$creditCardType=$_REQUEST['creditCardType'];
//$creditCardNo=$_REQUEST['creditCardNo'];
//$expireDate=$_REQUEST['expireDate'];
//$shippingAddress=$_REQUEST['shippingAddress'];

isAMember = false;
$host="localhost"; $user="jassange"; $passwd="#wiki13leaks"; $database="jassangedb";
$dbLink = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$dbLink);
print "email=$email<br>";
$query="SELECT password FROM member where email='$email'";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
   exit();
} else { 
   $num_rows = mysql_num_rows($result);
   if ($num_rows==1) {
         $myrow=mysql_fetch_array($result);
         if ($password==$myrow[0]) {
            print "login correct!<br>";
            isAMember = true;
         }
   } 
}

