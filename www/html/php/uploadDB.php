<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="C. Edward Chow" name=Author>
<LINK href="../csnet.css" type=text/css rel=STYLESHEET>
</head>
<body>
<center>
<img src="../WikiLeaks_files/ja-main.jpg" alt="wikileaks logo"
longdesc="wikileaks logo">
<h2>Please upload the secret files you would like share.<br />
maintained by Julian Assange</h2>
</center>

<?php
//extract($_REQUEST);
$email=$_REQUEST['email'];
$password=$_REQUEST['password'];
//print "email=$email; password=$password<br>";

if ($email != null) {
$match = 0;
$host="localhost"; $user="ja"; $passwd="wiki13leaks"; $database="jadb";
$dbLink = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$dbLink);
$query="SELECT password FROM member where email='$email'";
//print "query=$query<br />";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
   exit();
} else { 
   $num_rows = mysql_num_rows($result);
   //print "num_rows=$num_rows<br />\n";
   if ($num_rows==1) {
         $myrow=mysql_fetch_array($result);
         //print "myrow[0]=$myrow[0]; password=$password<br />\n";
         if ($password==$myrow[0]) {
            print "login correct!<br>";
            $match = 1;
         }
   } 
}
//print "match=$match<br />\n";

$uploaddir = '/var/www/html/secure/'. $email . '/';
//print "uploaddir=$uploaddir; <br>";

if (!file_exists($uploaddir)) {
   //print "mkdir $uploaddir<br>";
   mkdir($uploaddir, 0755);
} else {
     // print "$uploaddir exist<br>";
}

$filename= basename($_FILES['userfile']['name']);
//print "****filename=$filename<br>";
$uploadfile=$uploaddir . $filename;
//print "uploadfile=$uploadfile<br />\n";

if (!$match) {
   print "Please provide correct loginName and password<br>";
} elseif (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

$domain= $_SERVER['HTTP_HOST'];
//print "domain=$domain<br />\n";

$url='http://'.$domain.'/secure/'.$email.'/'. $filename;

echo '<pre>';

   echo "File is valid, and was successfully uploaded.\n";
   echo 'Here is the link to the saved file:';
   print "<a href=\"$url\"> $url</a>";
} else {
   echo "Possible file upload attack!<br />\n";
}
}

?> 

Please deposit the document to the doc direcotory. <br>
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="uploadDB.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="25000000" />
    <!-- Name of input element determines name in $_FILES array -->
<table>
  <tr><td>File to be deposit:</td><td><input name="userfile" type="file" /></td></tr>
  <tr><td>Your email(lowercase):</td><td><input name="email" type="text" value="jassange@gmail.com"/></td></tr>
  <tr><td>Your password:</td><td><input name="password" type="password"  /></td></tr>

</table> 
    <input type="submit" value="Send File" />
</form>
</body>
</html>
