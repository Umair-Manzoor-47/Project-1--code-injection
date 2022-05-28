<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="C. Edward Chow" name=Author>
<LINK href="../csnet.css" type=text/css rel=STYLESHEET>
</head>
<body>
<center>
<img src="../images/cs3110bannerV2.png" alt="cs3110 logo"
longdesc="CS3110 logo">
<h2>Repository for UCCS CS3110 Semester Project Document/Source Code</h2>
<h2>maintained by Edward Chow</h2>
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
//$degree=$_POST['degree'];
$dir=$_POST['dir'];
//print "loginname=$login  passwd=$passwd dir=$dir<br>";


$match=0;
if (!$login) {
   print "Require login<br>";
} elseif (!$passwd) {
   print "require password<br>";
} else {
   //print "checking login=$login and password=$passwd!";
   // valid input data
   if (preg_match("/^[a-zA-Z0-9]*$/", $login)) {
        // echo "data format correct.<br />";
    } else {
        echo "incorrect data format.<br />";
        sleep(10); 
    }

    if (preg_match("/^[-\d]*$/", $passwd)) {
        // echo "data format correct.<br />";
    } else {
        echo "incorrect format.<br />";
        sleep(10); 
    }

    if (preg_match("/^(doc)|(src)$/", $dir)) {
        // echo "data format correct.<br />";
    } else {
        echo "incorrect data format.<br />";
        sleep(20); 
    }
   // open file and print each line
   $match=0;
   if($myFile = fopen("../../CS3110F2013Grade.txt", "r")) {
      $myLine = fgets($myFile, 255); // skip title line
      while(!feof($myFile)) {
         $myLine = fgets($myFile, 255);
         $fields = preg_split("/\t/", $myLine);
         // be specific s not good
         //print "login=$fields[1] passwd=$fields[2]##<br>";
         $passwdInFile=preg_replace('/\"/', '', $fields[2]);
         // there are " on SID field
         $passwdInFile=trim($passwdInFile); // tough bug there is trailing 
         //print "after trim new passwd=$passwdInFile<br>";
         // white space /r maybe; result comparison failure
         // 995-53-0000 not the same 995-53-9988<space>
         $passwdInFile=preg_replace('/\-/', '', $passwdInFile);
         //print "after preg_replace remve - new passwd=$passwdInFile<br>";
         // there are " on SID field
         // print "after preg_replace new passwd=$passwdInFile<br>";
         if ($login == $fields[1]) {
            if ($passwd == $passwdInFile) {
               print "login correct<br>";
               $match=1;

$uploaddir = '/home/cs3110/public_html/studentproj/projF2013/'. $login . '/';
$uploadsubdir = $uploaddir .  $dir. '/';
//print "login=$login; uploaddir=$uploaddir; uploadsubdir=$uploadsubdir<br>";

if (!file_exists($uploaddir)) {
   //print "mkdir $uploaddir<br>";
   mkdir($uploaddir, 0755);
} else {
     // print "$uploaddir exist<br>";
}
if (!file_exists($uploadsubdir)) {
   //print "mkdir $uploadsubdir<br>";
   mkdir($uploadsubdir, 0755);
} else {
   //print "$uploadsubdir exist<br>";
}

$filename= basename($_FILES['userfile']['name']);
//print "****filename=$filename<br>";

if ($filename){

$uploadfile = $uploadsubdir . $filename;
print "uploadfile=$uploadfile<br>";

if (!$match) {
   print "Please provide correct LoginName and password<br>";
} elseif (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

$url='http://cs591.csnet.uccs.edu/~cs3110/studentproj/projF2013/'.$login.'/'.$dir.'/'. $filename;
//print "uploadfile=$uploadfile; url=$url<br />";

echo '<pre>';

   echo "File is valid, and was successfully uploaded.\n";
   echo 'Here is the link to the saved file:';
   print "<a href=\"$url\"> $url</a>";
} else {
   echo "Possible file upload attack!<br />\n";
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
      //print "open graduationList.txt failed!<br>";
   }
}

?> 

Please deposit the semester project report to the doc direcotory
and <br>the source code in src directory. <br>Select the related directory type below.
<br />
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="dangerUpload.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="25000000" />
    <!-- Name of input element determines name in $_FILES array -->
<table>
  <tr><td>File to be deposit:</td><td><input name="userfile" type="file" /></td></tr>
  <tr><td>Your UFP login name(lowercase):</td><td><input name="login" type="text" value="chow"/></td></tr>
  <tr><td>Your password (SID without dash):</td><td><input name="passwd" type="password" value="111111111" /></td></tr>

  <tr><td>The directory type:</td><td><select size="2" name="dir">
       <option selected>doc</option>
       <option>src</option>
    </select></td></tr>
</table> 
    <input type="submit" value="Send File" />
</form>
</body>
</html>
