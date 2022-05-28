<!-- url: http://cs.uccs.edu/~cs591/cgi-bin/labreserve/reserve.php
     Authors:    C. Edward Chow
     Created:    11/2/2005
     Revised by: 

     Feel free to use and revise it.  
     Email me your bug fix and improvement, chow@cs.uccs.edu.
     Please retain the author and revision info.

-->
<HTML><HEAD><TITLE>CS526 Hw3 Lab  Windom VMware Reservation Web Page</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="C. Edward Chow" name=Author>
<BODY background="../images/marble1.jpg">
<center>
<h2>CS526 Lab Reservation Web Page</h2>
</center>
Please enter your CS Unix login name and all 9 digits of your Student ID.<br>
Then select the date.  The web page will be refreshed with a list of 
availabe time slots.  For each time slot, we allow 3 persons to work on windom.
Try not to reserve more than two time slots per day.
<hr>
<?php
$host='localhost';
$dbuser='cs301';
$dbpasswd='cs07web';
$database='cs301db';
$table='timeslot';
$db = mysql_connect($host, $dbuser, $dbpasswd);
mysql_select_db($database,$db);

#extract($_REQUEST);
$login=$_POST['login'];
$passwd=$_POST['passwd'];
$date=$_POST['date'];
$cancel=$_POST['cancel'];
$reserve=$_POST['reserve'];

if (!$login) { 
   print "require login<br>"; 
   print "For testing, set default login to aalmuray<br>";
   $login="aalmuray";
   print "set default passwd to 123456789<br>";
   $passwd="123456789";
} elseif (!$passwd) { 
   print "require password<br>";
} else {
   // check login and password
   // open file and print each line
   $match=0;
   print "userLogin=$login; userPasswd=$passwd<br />\n";
   if($myFile = fopen("/var/www/data/CS3110F2015Grade.txt", "r")) {
      $myLine = fgets($myFile, 255); // skip title line
      while(!feof($myFile)) {
         $myLine = fgets($myFile, 255);
         $fields = preg_split("/\t/", $myLine);  // be specific /s not good
         //print "login=$fields[1] passwd=$fields[2]<br>";
         $passwdInFile=preg_replace('/-/', '', $fields[2]); 
         $passwdInFile=preg_replace('/"/', '', $passwdInFile); 
         //print "after preg_replace new passwd=$passwdInFile<br>";
         if ($login == $fields[1]) {
          //  print "login match fields[1]<br>\n";
            if ($passwd == $passwdInFile) {
               print "login correct<br>";
               $match=1;
            } else {
               print "login incorrect<br>"; 
               sleep(10);
            }
            break;
         }
      }
      fclose($myFile);
   } else {
      print "open grade file failed!<br />";
   }
   if ($match==1) { 
      if ($reserve) { 
         print "reserve=$reserve selected<br>"; 
         // parsing the reserve value
         $fields = preg_split("/ /", $reserve);  
         $testbedChoice=$fields[1];
         $reserveDate=$fields[2];
         $reserveTimeslot=$fields[3];
         $sql = "INSERT INTO $table (Testbed, ReserveDate, ReserveTimeslot, Login) VALUES ($testbedChoice, '$reserveDate', '$reserveTimeslot', '$login');";
 
         //print "before sql=$sql<br>result=$result<br>";
         $result = mysql_query($sql,$db);
         print "sql=$sql<br>result=$result<br>";
         $fields = preg_split("/-/", $reserveDate);  
         $date=$fields[2];
      } elseif ($cancel) {
         print "cancel=$cancel selected<br>"; 
         $fields = preg_split("/ /", $cancel);  
         $reserveLogin=$fields[1];
         if ($reserveLogin == $login) { 
            // can be exploited, should check the database in stead form input
            $testbedChoice=$fields[2];
            $reserveDate=$fields[3];
            $reserveTimeslot=$fields[4];
$sql="DELETE FROM $table WHERE TestBed=$testbedChoice AND ReserveDate='$reserveDate' AND ReserveTimeslot='$reserveTimeslot' AND Login='$login'";
            $result = mysql_query($sql ,$db);
            //print "sql=$sql<br>result=$result<br>";
            $fields = preg_split("/-/", $reserveDate);  
            $date=$fields[2];
         } else {
            print "you are not the owner of the timeslot!<br>";
         }
      } else {
         print "date=$date selected<br>";
      }
   }
}
?>

<form action="reserve.php" method=post>
Login: <input type=text name=login value=<?php echo $login ?>><br>
Password: <input type=password name=passwd value=<?php echo $passwd ?>><br>
<table border=1>
  <tr> 
    <td colspan="7" style="text-align:right;background:#EEDDCC">
      <div align="center">April 2006</div>
    </td>
  </tr>
  <tr style="text-align:center;background:#C8C896"> 
    <td>Sun</td>
    <td>Mon</td>
    <td>Tue</td>
    <td>Wed</td>
    <td>Thu</td>
    <td>Fri</td>
    <td>Sat</td>
  </tr>
  <tr style="text-align:center;background:lightgrey"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
<?php
for ($i=1; $i<31; $i++) {
   if ($i<=14 || $i>=21) {
      if ($i%7==1) {
         print "<td>$i</td>\n";;
         print "</tr>\n";
      } elseif ($i%7==2) {
         print "<tr style=\"text-align:center;background:lightgrey\">\n";
         print "<td>$i</td>\n";;
      } else {
         print "<td>$i</td>\n";;
      }
   } elseif ($i%7==1) { 
      print "<td>";
      print "<input type=submit name=date value=";
      printf("\"%2d\" ", $i);
      print "style=\"font-family:Courier; text-align:center;background:lime\">\n";
      print "</td></tr>\n";
   } elseif ($i%7==2){
      print "<tr style=\"text-align:center;background:lightgrey\">\n";
      print "<td>";
      print "<input type=submit name=date value=";
      printf("\"%2d\" ", $i);
      print "style=\"font-family:Courier; text-align:center;background:pink\">\n";
      print "</td>\n";
   } else {
      print "<td>";
      // print "<input type=submit name=date onclick=\"submit();\" value=";
      print "<input type=submit name=date value=";
      printf("\"%2d\" ", $i);
      print "style=\"font-family:Courier; text-align:center;background:cyan\">\n";
      print "</td>\n";
   }
}
?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>

<?php
if (!$date) { $date="15";}
$sdate=preg_replace('/ /', '', $date); // remove space in date
$queryDate= sprintf("2006-4-%02d", $sdate);
print "<h2>For date=$queryDate, here is the reservation status</h2>";

print "<table cellspacing=\"0\" cellpadding=\"0\"><tr>\n";
for ($k=1; $k<4; ++$k ) {
$result = mysql_query("SELECT ReserveTimeslot,login FROM $table where ReserveDate='$queryDate' and Testbed=$k",$db);

print ("<td><table bgcolor=\"#EDDFC9\" border=\"1\" cellspacing=\"2\"><tr>");
if ($k==1) print ("<th>ReserveTimeslot</th>");
print ("<th>Status</th></tr>\n");
$reserve1='';
while ($myrow = mysql_fetch_array($result)) {
   //$reserve1['$myrow[0]']=$myrow[1]; not correct
   $reserve1[$myrow[0]]=$myrow[1];
   // print "myrow[0]=$myrow[0]; myrow[1]=$myrow[1]<br>";
}

for ($i=0; $i<24; $i+=2) {
   $timeslot=sprintf("%02d:00:00",$i);
   $dateTimeslot=sprintf("$queryDate %02d:00:00",$i);
   if ($i%4==1){
      print ("<tr bgcolor=\"#93EEFF\">");
   } else {
      print ("<tr bgcolor=\"#93FFAA\">");
   }
   // $owner=$reserve1['$timeslot']; incorrect
   $owner=$reserve1[$timeslot];
   if ($k==1) print "<td align=center>$timeslot</td>";
   if (!$owner) {
      print "<td><input type=submit style=background:lime name=reserve value=\"reserve $k $dateTimeslot\"></td>";
   } else {
      print "<td><input type=submit style=background:pink name=cancel value=\"cancelby $owner $k $dateTimeslot\"></td>";
   }
}
print ("</table></td>");
}
print "</tr></table>";
?>
</form>
</body>
</html>
