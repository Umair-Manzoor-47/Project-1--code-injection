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
if (!preg_match("/^[a-zA-Z0-9\s,]{4,30}$/", $fullName)) {
   print "incorrent fullName format. </body></html>";
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
$mysqli=new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}
#$dbLink = mysql_connect($host, $user, $passwd);
#mysql_select_db($database,$dbLink);
print "email=$email<br>";
$query="SELECT email FROM member1 where email='$email'";
if(!($result = $mysqli->query($query))) {
   die('There was an error running the query [' . $mysqli->error . ']');
} else { 
   print "query=$query<br />\n";
   $num_rows = $result->num_rows;
   print "num_row=$num_rows<br />\n";
   if ($num_rows==0) {
      print "no member with such email address<br />process with insert<br />\n";
      $query="INSERT INTO member1 (fullName, email, password) VALUES (?, ?, ?)";
      if (!($stmt=$mysqli->prepare($query))) {
         echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
         exit(1);
      }
      $bpwd='-'.$password;  // temporary block access until email confirm
      if (!$stmt->bind_param("sss", $fullName, $email, $bpwd)) {
         echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
         exit(1);
      }
      $result=$stmt->execute();
      print "execute statement with query using prepare bind_param query=$query<br />\n";
      if (!$result) {
         echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
         exit(1);
      }
      print "insert successful<br />\n";
// add - sign to new applicant to temporarily block the access until 
// the link in the confirm email is clicked by the user.
      if (mysql_affected_rows() == 1) {
         $query="SELECT customerID FROM member1 where email='$email'";
         $result=$mysqli->query($query);
         $myrow=$mysqli->fetch_array($result);
         $customerID=$myrow[0];
         print "your customerID is $customerID<br>";
      } else {
         print 'rownumber==0?<br>';
      }
   } else {
      $myrow=mysqli_fetch_array($result);
      $customerID=$myrow[0];
      print "you already registered. customerID=$customerID<br>";
   }
}
$domain=$_SERVER['HTTP_HOST'];

$msg="An email is sent to your email server. Please confirm your membership request using the link in the email.";
$keystring=$email.'cyber';
$str=md5($keystring);
print "msg=$msg; keystring=$keystring; str=$str<br />\n";
$emailBody="Please click <a href=\"http://$domain\php/confirm.php?email=$email&key=$str\"> this link </a> to confirm your registration.   Sincerely, Cyber Club WebMaster ";
$to=$email;
$subject="You have requested to join cyber club. Please confirm";
#system("echo \"$emailBody\" | mail -s $subject -c $to cchow@uccs.edu");
$header="From: root@cs3110.cnset.uccs.edu\r\n" .
        "Mime-Version: 1.0\r\n" .
        "Content-type: text/html; charset=\"iso-8859-1\"\r\n\r\n"; 
mail($to, $subject, $emailBody, $header);
#print $msg;

?>
</body>
</html>
