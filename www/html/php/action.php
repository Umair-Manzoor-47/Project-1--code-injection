<?php
// header('Access-Control-Allow-Origin: http://walrus.uccs.edu');
header('Access-Control-Allow-Origin: *');
/*
XMLHttpRequest cannot load http://chow.csnet.uccs.edu/php/accept.php?key=Uc2013lions&email=Julia%20Assange&command=accept. No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://walrus.uccs.edu' is therefore not allowed access. 
*/
$email=$_GET['email'];
$key=$_GET['key'];
$command=$_GET['command'];
print "email=$email; key=$key; command=$command <br />\n";

if (!$email) { print "no email";  exit(1);}
if (!$key) { print "no key";  exit(1);}
if (!$command) { print "no command";  exit(1);}

if ($key != 'Uc2013lions') { print "incorrect key"; exit(1); }
if ($command == 'accept') { $status=1; }
else if ($command == 'reject') { $status=-1; }
else { print "incorrect commmand"; exit(1); }


$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$mysqli = new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}

/* retrieve password */
/* Select queries return a resultset */
if (!$result = $mysqli->query("SELECT password FROM member1 where email='$email'")) {
   die('There was an error running the query [' . $mysqli->error . ']');
}
$row = $result->fetch_assoc();
$pwd = $row['password'];
// take out the - sign now if it is accepte
if ($command == 'accept') {
   $p=$pwd;
   // bad idea to strip one character. it could continue to strip not just -
   //$groups = substr($g, 1, strlen($g)-1);
   if (substr($p, 0, 1) == '+') {
      $pwd = substr($p, 1, strlen($p)-1);
   } 
// else no change to $pwd value  only those with email confirm can be accepted
}
if ($command == 'reject') {
   $p=$pwd;
   if (substr($p, 0, 1) == '+' || substr($p, 0, 1) == '-') {
         $pwd = '!'.substr($p, 1, strlen($p)-1); //strip + or -
   } elseif (substr($p, 0, 1) != '!') {
         // legitimate user got revoke
         $pwd = '!'.$p;
   } else {
         // user already being rejected; probably should remove them in the future
   }
}

/* Prepared statement, stage 1: prepare; do not miss , between set values */
if (!($stmt = $mysqli->prepare("UPDATE member1 SET password=?, status=? where email=?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    exit(1);
}

// need to change the first paramter from is to sis, it is the types of param */
if (!$stmt->bind_param("sis", $pwd, $status, $email)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    exit(1);
}

$result=$stmt->execute();
if (!$result) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    exit(1);
}
//print "result=$result";
echo $status;
//echo "Success";
?>
