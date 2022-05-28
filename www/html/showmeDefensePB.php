<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
</head>
<body>
<h1>Member Profile Request</h1>
<?php
foreach ($_REQUEST as $key => $value) {
   print "name=$key value=$value<br>";
}
$email=$_GET['email'];
$password=$_GET['passwd'];

if (!empty($email)) {
if (!preg_match("/^[a-zA-Z0-9.]+\@[a-zA-Z0-9.]+$/", $email)) {
   print "incorrent email format. </body></html>";
   exit(0);
}
if (!preg_match("/^[#a-zA-Z0-9.$]{4,16}$/", $password)) {
   print "incorrent password format. </body></html>";
   exit(0);
}
$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$mysqli=new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}
$query="SELECT fullName, email, password, status FROM member1 WHERE email=?";
print "query=$query<br />\n";
if(!($stmt=$mysqli->prepare($query))) {
   echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
   exit(1);
}
if (!$stmt->bind_param("s", $email)) {
   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
   exit(1);
}
if (!$stmt->execute()) {
   echo "Execute() failed: (" . $stmt->errno . ") " . $stmt->error;
   exit(1);
}
$stmt->bind_result($col1, $col2, $col3, $col4);
print "execute statement with query using prepare bind_param query=$query<br />\n";     
print "<h1>Here is your current profile info.</h1><br />\n";
print "<table class=\"alternate\">\n<tr>";
print "<td>FullName</td><td>Email</td><td>Password</td><td>Status</td>";
print "</tr>\n";

//$field_count=$result->field_count;
while($stmt->fetch()) {
   print "<tr><td>".$col1."</td><td>".$col2."</td><td>".$col3."</td><td>".$col4."</td></tr>";
}
print "</table><br /><hr />\n";
} else {
   print "email=$email<br />\n";
}
?>

Please enter your email address and password.
<form action="showmeDefensePB.php" method="GET">
<table class="alternate2">
<tr><td>Email:</td><td><input type="text" name="email" size="50" value="cchow@uccs.edu"></td></tr>
<tr><td>
Password:</td><td><input type="password" name="passwd" value="1234"></td></tr>
<tr><td><input type="submit" value="Submit"></td><td></td></tr>
</table>
</form>
</body>
</html>
