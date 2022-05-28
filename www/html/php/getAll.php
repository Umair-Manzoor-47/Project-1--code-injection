<?php
// need the following if request is from any machine with vpn to uccs
header('Access-Control-Allow-Origin: *');
$key=$_GET['key'];
if (!$key) { print "***no key";  exit(1);}
if ($key != 'Uc2013lions') { print "***incorrect key"; exit(1); }

//$host="localhost"; $user="ja"; $passwd="wiki13leaks"; $database="jadb";
$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
//$dbLink = mysql_connect($host, $user, $passwd);
$mysqli = new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "***Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}

// A QUICK QUERY ON MEMBER TABLE
// actually we normal know the columns names and can hard coded to save time 
$query = "Show Columns from member1";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

// GOING THROUGH THE DATA
$titleLine="";
$i=0;
if($result->num_rows > 0) {
   while($row = $result->fetch_assoc()) {
      $titleLine .= $row['Field']. ',';
      $col[$i]=$row['Field'];
      // print_r($row);
   }
   $titleLine = substr($titleLine, 0, -1);
} else {
   echo '***NO RESULTS';	
}
print "$titleLine\n";     
$result->close();  // otherwise title line repeart below

// print data line;  remove where status = 0;
$query="select * from member1";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
// GOING THROUGH THE DATA
if($result->num_rows > 0) {
   while($row = $result->fetch_row()) {
         print $row[0].',"'.$row[1].'","'.$row[2].'","'.$row[3].'",'.$row[4]."\n";
   } 
} else {
   echo '***NO RESULTS';
}

// CLOSE CONNECTION
mysqli_close($mysqli);
//echo "***Success";
?>
