<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
</head>
<body>
<img src="../WikiLeaks_files/ja-mainA.jpg" alt="wikileaks logo"
longdesc="wikileaks logo">
<h2>Thank your for your donation.</h2>
<?php
//extract($_REQUEST);
$email=$_POST['email'];
$emailConfirmed=$_POST['emailConfirmed'];
$password=$_POST['password'];
$passwordConfirmed=$_POST['passwordConfirmed'];
$fullName=$_POST['fullName'];

// should check input right away

$host="localhost"; $user="ja"; $passwd="wiki13leaks"; $database="jadb";
$dbLink = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$dbLink);
print "email=$email<br>";
$query="SELECT email FROM member where email='$email'";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
   exit();
} else { 
   $num_rows = mysql_num_rows($result);
   if ($num_rows==0) {
      $query="INSERT INTO member (fullName, email, password) VALUES ('$fullName', '$email', '$password')";
       print "query=$query<br>";
      if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
      } elseif (mysql_affected_rows() == 1) {
         $query="SELECT customerID FROM customer where email='$email'";
         $result=mysql_query($query, $dbLink);
         $myrow=mysql_fetch_array($result);
         $customerID=$myrow[0];
         print "your customerID is $customerID<br>";
      } else {
         print 'rownumber==0?<br>';
      }
   } else {
      $myrow=mysql_fetch_array($result);
      $customerID=$myrow[0];
      print "you already registered. customerID=$customerID<br>";
   }
}

system("htpasswd -bm /var/www/html/apacheticket $email $password");

$baseuri= $_SERVER['PHP_SELF'];
//print "baseuri=$baseuri<br />\n";
$domain=$_SERVER['HTTP_HOST'];
//print "domain=$domain<br />\n";

$msg="You have successfully registered.  Please use the following link to enter member only area. <a href=\"http://$domain/securedb\">http://$domain/securedb/</a>, or upload the document at <a href=\"http://$domain\php/uploadDB.php\">uploadDB.php</a>";

$to=$email;
$subject="$fullName are registered";
$header="From: root\@$domain\r\n" .
        "Mime-Version: 1.0\r\n" .
        "Content-type: text/html; charset=\"iso-8859-1\"\r\n\r\n"; 
//mail($to, $subject, $msg, $header);
$cmd = "mail -s "$subject" $to cchow\@uccs.edu < $smg";
system($cmd);
print $msg;

?>
</body>
</html>
