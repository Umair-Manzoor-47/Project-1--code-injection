<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="C. Edward Chow" name=Author>
<LINK href="csnet.css" type=text/css rel=STYLESHEET>
</head>
<body>
<center>
<table bgcolor="silver">
<tr border=3 align=center><td>
<img src="images/gscLogo.png" alt="gsc logo"
longdesc="gsc logo">
</td></tr>
</table>
<h1>Repository for UCCS CS PhD/Master Thesis/Project Document/Source Code</h1>
<h2>maintained by UCCS CS Graduate Study Committee</h2>
</center>

<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used
// instead
// of $_FILES.
//extract($_REQUEST);
//danger practice to use extract, hacker could set other local 
// variables.
$login=$_POST['login'];
$passwd=$_POST['passwd'];
$degree=$_POST['degree'];
$dir=$_POST['dir'];

//print "loginname=$login  passwd=$passwd dir=$dir<br>";

$match=0;
if (!$login) {
   print "require login<br>";
} elseif (!$passwd) {
   print "require password<br>";
} else {
   //print "checking login=$login and password=$passwd!";
   // valid input data
   // open file and print each line
   $match=0;
   //print "prepare to open gralist file <br />";
   if($myFile = fopen("../data/graduationList.txt", "r")) {
      $myLine = fgets($myFile, 255); // skip title line
      while(!feof($myFile)) {
         $myLine = fgets($myFile, 255);
         $fields = preg_split("/\t/", $myLine);
         // be specific s not good
         $passwdInFile=preg_replace('/\"/', '', $fields[2]);
         $passwdInFile=preg_replace('/-/', '', $passwdInFile);
         // there are " on SID field
         $passwdInFile=trim($passwdInFile); // tough bug there is trailing 
         // white space /r maybe; result comparison failure
         // 995-51-0000 not the same 995-51-0088<space>
         //print "login=$fields[1]# passwd=$passwdInFile##passwd=$passwd###<br>";
         if ($login == $fields[1]) {
            if ($passwd == $passwdInFile) {
               print "login correct<br>";
               $match=1;

$uploaddir = '/var/www/html/gsc/' .$degree.'/'. $login . '/';
$uploadsubdir = $uploaddir .  $dir. '/';
//print "login=$login; uploaddir=$uploaddir; uploadsubdir=$uploadsubdir<br>";

#if (!file_exists($uploaddir)) {
#   mkdir($uploaddir, 0755);
#   if (!file_exists($uploadsubdir)) {
#      mkdir($uploadsubdir, 0755);
#   }
#}
# the above will not create second directory
# such as src

if (!file_exists($uploaddir)) {
   mkdir($uploaddir, 0755);
}
if (!file_exists($uploadsubdir)) {
      mkdir($uploadsubdir, 0755);
}

$filename= basename($_FILES['userfile']['name']);
//print "****filename=$filename<br>";

if ($filename){
$arr=explode('.', $filename);
$ext = end($arr);
$filenamebase=$arr[0];
//print "ext=$ext; filenamebase=$filenamebase<br>";

$uploadfile = $uploadsubdir . $filename;
//print "uploadfile=$uploadfile<br>";

if (!$match) {
   print "Please provide correct LoginName and password<br>";
} elseif (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

$host=$_SERVER['HTTP_HOST'];
$url='http://'.$host.'/gsc/'.$degree. '/'.$login.'/'.$dir.'/'. $filename;
//print "uploadfile=$uploadfile; url=$url<br />";
system("chmod 755 $uploadfile");

echo '<pre>';

   echo "File is valid, and was successfully uploaded.\n";
   echo 'Here is the link to the saved file:';
   print "<a href=\"$url\"> $url</a> <br />";
} else {
   echo "Possible file upload attack!\n";
}

print "</pre>";
}






            } else {
               print "login incorrect<br>";
               sleep(10);
            }
            break;
         }
      }
      fclose($myFile);
   } else {
      print "open graduationList.txt failed!<br>";
   }
}

?> 

Please deposit the proposal and thesis/project report to the doc direcotory
and <br>the source code in src directory. <br>Select your degree and the related directory type below.
<br />
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
    <!-- Name of input element determines name in $_FILES array -->
<table>
  <tr><td>file to be deposit:</td><td><input name="userfile" type="file" /></td></tr>
  <tr><td>Your UFP login name(lowercase):</td><td><input name="login" type="text" value="jgray"/></td></tr>
  <tr><td>Your password (SID without dash, nnnnnnnnn):</td><td><input name="passwd" type="password" value="999110066" /></td></tr>

  <tr><td>The directory type:</td><td><select size="2" name="dir">
       <option selected>doc</option>
       <option>src</option>
    </select></td></tr>
  <tr><td>The degree type:</td><td><select size="2" name="degree">
       <option selected>master</option>
       <option>phd</option>
    </select></td></tr>
</table> 
    <input type="submit" value="Send File" />
</form>
</body>
</html>
