<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="C. Edward Chow" name=Author>
<LINK href="csnet.css" type=text/css rel=STYLESHEET>
<script>
function checkAll() {
   var isOK = true;
   //reset className to be empty witout error
   document.form1.studentLogin.className = "";
   document.form1.studentLoginConfirmed.className = "";
   document.form1.studentSID.className = "";
   document.form1.studentSIDConfirmed.className = "";
   document.getElementById('msg1').textContent = "";
   if (document.form1.studentLogin.value != document.form1.studentLoginConfirmed.value) {
       isOK = false;
       document.form1.studentLogin.className += " error";
       document.form1.studentLoginConfirmed.className += " error";
       document.getElementById('msg1').textContent = "studentLogin not the same; ";
   }
   if (document.form1.studentSID.value != document.form1.studentSIDConfirmed.value ) {
       isOK = false;
       document.form1.studentSID.className += " error2";
       document.form1.studentSIDConfirmed.className += " error2";
       document.getElementById('msg1').textContent += " studentSID not the same";
   }
   return isOK;
}
</script>
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
//print "loginname=$login  passwd=$passwd dir=$dir<br>";
$gscLogin=$_POST['gscLogin'];
$gscPasswd=$_POST['gscPasswd'];
$studentLogin=$_POST['studentLogin'];
$studentSID=$_POST['studentSID'];
$studentName=$_POST['studentName'];


$match=0;
if (!$gscLogin) {
   print "require gsc login<br>";
} elseif (!$gscPasswd) {
   print "require gsc password<br>";
} elseif (!$studentLogin) {
   print "require student login<br>";
} elseif (!$studentSID) {
   print "require student SID<br>";
} else {
   //print "checking login=$gscLogin and password=$gscPasswd!<br />\n";
   //print "checking studentlogin=$studentLogin and SID=$studentSID!<br />\n";
   // valid input data

   // open file and print each line
   $match=0;
   //print "open gscList.txt<br />\n";
   if($myFile = fopen("../data/gscList.txt", "r")) {
	//	print "open my file =gscList.txt successful<br />\n";
      while(!feof($myFile)) {
         $myLine = fgets($myFile, 255);
	//	print "myline=$myline<br />\n";
         $fields = preg_split("/\t/", $myLine);
         // be specific s not good
         // print "login=$fields[1] passwd=$fields[2]##passwd=$passwd<br>";
         $passwdInFile=preg_replace('/\"/', '', $fields[2]);
         // there are " on SID field
         $passwdInFile=trim($fields[2]); // tough bug there is trailing 
         // white space /r maybe; result comparison failure
         // print "after preg_replace new passwd=$passwdInFile<br>";
         if ($gscLogin == $fields[1]) {
            if ($gscPasswd == $passwdInFile) {
               print "login correct<br>";
               $match=1;
	       if ($graFile= fopen("../data/graduationList.txt", "a")){ 
		   fprintf($graFile, "\"%s\"\t%s\t%s\n", $studentName, $studentLogin, $studentSID);
		   print "student info inserted successfully to the password file<br /><br />\n";
                   fclose($graFile);
	       } else {
                   print "open graduationList.txt failed!\n"; break;
               }
$host=$_SERVER['HTTP_HOST'];
$msg = "Dear Graduate Student:<br />You got this email because you have registered for phd dissertation/master thesis/project classes. Please deposit the proposal/report (draft or final version)/source code to Graduate Study Committee archive site. <a href=\"http://$host/upload.php\">http://$host.uccs.edu/upload.php</a>. This is a temporary archive site for protecting your idea.  Your final report should be deposit to permanent archive site with <a href=\"http://cs.uccs.edu/~gsc/php/upload.php\">http://cs.uccs.edu/~gsc/php/upload.php</a>. and you can reference them in your report or future work using http://cs.uccs.edu/~gsc/pub/phd/$studentLogin/ or http://cs.uccs.edu/~gsc/pub/master/$studentLogin/.\nEmail your committee the url of your proposal/report instead of as attachments.<br /><br />UCCS CS Graduate Study Committee.";

$cmd = "mail -s 'your account is set up' $studentLogin\@uccs.edu < $msg";
print "cmd=$cmd<br />\n";
system($cmd);

                    break;

	         }
         }
      }
      if (!$match) {
         print "gsc credential not correct<br />\n";
      }
   } else {
      print "open gscList.txt failed!\n";
   }
}
?> 

Please enter gsc login,  gsc password, <br /> and
student fullName, student uccs login (appear as first part in their uccs studentLogin address right before @) , and student SID.
<br />
<!-- The data encoding type, enctype, MUST be specified as below -->
<span class="error" id="msg1"></span>
<form name="form1" enctype="multipart/form-data" action="register.php" method="POST">
<table>
  <tr><td>gsc Login:</td><td><input name="gscLogin" type="text" value="gsc" /></td></tr>
  <tr><td>gsc Password:</td><td><input name="gscPasswd" type="password" 
        value="#cs00net$"/></td></tr>
  <tr><td>student Name:</td><td><input name="studentName" type="text" 
        value="adavis" /></td></tr>
  <tr><td>student UFP login:</td><td><input name="studentLogin" type="text" 
        value="Ackman Davis" /></td></tr>
  <tr><td>Confirm student UFP login:</td><td><input name="studentLoginConfirmed" type="text" value="adavis" /></td></tr>
  <tr><td>student SID without dash, nnnnnnnnn:</td><td><input type="text" name="studentSID" value="111222333" /></td></tr>
  <tr><td>Confirm student SID without dash:</td><td><input type="text" name="studentSIDConfirmed" value="111222333"/></td></tr>
  </table>
<input type="submit" value="Register" />
</form>
</body>
</html>
