<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
foreach ($_REQUEST as $key => $value) {
   print "name=$key value=$value<br>";
}
$email=$_POST['email'];
$emailConfirmed=$_POST['emailConfirmed'];
$password=$_POST['password'];
// $groups=$_POST['groups'];
$passwordConfirmed=$_POST['passwordConfirmed'];
$fullName=$_POST['fullName'];

if (!preg_match("/^[a-zA-Z0-9.]+\@[a-zA-Z0-9.]+$/", $email)) {
   print "incorrent email format. </body></html>";
   exit(0);
}
if (!preg_match("/^[#a-zA-Z0-9.$]{4,16}$/", $password)) {
   print "incorrent password format. </body></html>";
   exit(0);
}
if (!preg_match("/^[a-zA-Z0-9,\s]{6,50}$/", $fullname)) {
   print "incorrent fullname format. </body></html>";
   exit(0);
}
if ($email != $emailConfirmed) {
   print "<span class=\"error\">email != emailConfirmed</span></body></html>";
   exit(0);
}
if ($password != $passwordConfirmed) {
   print "<span class=\"error\">password != passwordConfirmed</span><br /></body></html>";
   exit(0);
}

$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$dbLink = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$dbLink);
print "email=$email<br>";
$query="SELECT email FROM member where email='$email'";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
//   exit();
} else { 
   $num_rows = mysql_num_rows($result);
   if ($num_rows==0) {
      $query="INSERT INTO member (fullName, email, password) VALUES ('$fullName', '$email', '$password')";
// add - sign to new applicant to temporarily block the access unitl 
// admin accept/approve the application
       print "query=$query<br>";
      if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
      } elseif (mysql_affected_rows() == 1) {
         $query="SELECT customerID FROM member where email='$email'";
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
$domain=$_SERVER['HTTP_HOST'];

$msg="your registration is being approved.  Please use the following link to enter member only area. <a href=\"http://$domain/sec/\">http://$domain/sec/</a>.";
$to=$email;
$subject="You are registered";
#system("echo \"$msg\" | mail -s 'registered wait for approval' -c $to cchow@uccs.edu");
$mailcmd ="echo \"$msg\" | mail -s 'registered wait for approval' -c $to cchow@uccs.edu";
file_put_contents("file:///../midterm/mailcmd.txt", $mailcmd);
print "<br />mailcmd=$mailcmd<br />/n";
system($mailcmd);
#$header="From: root@chow.cnset.uccs.edu\r\n" .
        "Mime-Version: 1.0\r\n" .
        "Content-type: text/html; charset=\"iso-8859-1\"\r\n\r\n"; 
#mail($to, $subject, $msg, $header);
print $msg;

?>
</body>
</html>
