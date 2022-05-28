<?php
//extract($_REQUEST);
$counter=$_GET['counter'];
header("Content-type: image/png");
$db = mysql_connect("localhost", "cs301", "cs07web");
mysql_select_db("cs301db",$db);
$result = mysql_query("CREATE TABLE counter (CounterName varchar(30),
CounterValue int)");
$result = mysql_query("SELECT * FROM counter where CounterName='$counter'",$db);

if (mysql_num_rows($result) == 1) {
   $freq = mysql_result($result,0,"CounterValue");
   $freq++;
   $result = mysql_query(
"UPDATE counter set CounterValue=$freq where CounterName='$counter'", $db);
} else { // not exist
   // create a new entry
   $result = mysql_query(
"INSERT INTO counter (CounterName, CounterValue) values ('$counter', 1)", $db);
   $freq = 1;
} 
$counterString = sprintf("%06d", $freq);

// $length = length($counterString);
$length = strlen($counterString);
$im = ImageCreate($length*14-2,20);
$black = ImageColorAllocate($im, 0, 0, 0);
$red = ImageColorAllocate($im, 255, 0, 0);      
$blue = ImageColorAllocate($im, 0,0,255);
$green = ImageColorAllocate($im, 0, 255, 0);

// Imagestring($im, 5, 2, 2 $counterString, $green);

//$width = ImageFontWidth(5);
$width = 14;
for ($i=0; $i < $length; $i++) {
   Imagestring($im, 5, 2+$i*$width, 2, substr($counterString, $i, 1), $green);
   if ($i < $length-1) {
      ImageFilledRectangle($im, 12+$i*$width, 0, 13+$i*$width, 20, $red);
   }
}

# print the image to stdout
ImagePNG($im);
Imagedestroy($im);
?>   
