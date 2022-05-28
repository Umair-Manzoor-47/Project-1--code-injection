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
$email=$_POST['email'];
$password=$_POST['password'];

/*
if (!preg_match("/^[a-zA-Z0-9.]+\@[a-zA-Z0-9.]+$/", $email)) {
   print "incorrent email format. </body></html>";
   exit(0);
}
if (!preg_match("/^[#a-zA-Z0-9.$]{4,16}$/", $password)) {
   print "incorrent password format. </body></html>";
   exit(0);
}
*/
if (!empty($email)) {
$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$mysqli=new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}
//print "email=$email<br>";
$query="SELECT * FROM member1 where email='$email'";
print "query=$query<br />\n";
if(!($result = $mysqli->query($query))) {
   die('There was an error running the query [' . $mysqli->error . ']');
} 
$num_rows = $result->num_rows;
//print "num_row=$num_rows<br />\n";
print "<h1>Here is your current profile info.</h1><br />\n";
print "<table class=\"alternate\">\n<tr>";
while ($property = mysqli_fetch_field($result)) {
    print "<td>".$property->name."</td>";
}
print "</tr>\n";

$field_count=$result->field_count;
while($row = $result->fetch_array()) {
   print "<tr>";
   for ($j=0; $j<$field_count; $j++) {
      print "<td>".$row[$j]."</td>";
   }
   print "</tr>\n";
}
print "</table><br /><hr />\n";
}
?>

Please enter your email address and password.
<form action="showmedetail.php" method="POST">
<table class="alternate2">
<tr><td>Email:</td><td><input type="text" name="email" value="cchow@uccs.edu"></td></tr>
<tr><td>
Password:</td><td><input type="password" name="passwd" value="1234"></td></tr>
<tr><td><input type="submit" value="Submit"></td><td></td></tr>
</table>
</form>
</body>
</html>
