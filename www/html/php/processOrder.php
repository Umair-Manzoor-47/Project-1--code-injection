<html>
<head>
<title>processing order</title>
<link href="../csnet.css" type="text/css" rel="stylesheet">
<script>
var cookies = [
<?php
//
// the following code retrieves inventory table and save the item list
// to $items and $inventory
//
$host="localhost"; $user="cs301"; $passwd="cs07web"; $database="cs301db";
$dbLink = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$dbLink);
$query="SELECT item, amount FROM inventory";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
   exit();
} else {
   $num_rows = mysql_num_rows($result);
   for ($i=0; $i<$num_rows; $i++) {
      $myrow=mysql_fetch_array($result);
      $cookies[$i]=$myrow[0];
      $cookieJug[$myrow[0]]=$myrow[1];
      print "'$myrow[0]',";
   }
}

$query="SELECT item, unitPrice FROM price";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
   exit();
} else {
   $num_rows = mysql_num_rows($result);
   for ($i=0; $i<$num_rows; $i++) {
      $myrow=mysql_fetch_array($result);
      $cookiePrice[$myrow[0]]=$myrow[1];
   }
}

?>
]
</script>
</head>
<body>
<h1>Processing Order</h1>
<hr>
<form method="Post" 
      action="confirmOrder.php">
<?php

print "<b>\n";
print "<p>Please confirm the order.</p>\n";
print "<table class=\"alternate\"  border=\"1\">\n";
print "<tr><th>Type of Items</th><th>Unit Price</th><th>No. of Items</th><th>Price</th></tr>\n";
$totalPrice = 0;
$incorrectInput = 0;
foreach ($cookies as $type) {
  $noOfBoxes = $_REQUEST[$type];
  $unitPrice = $cookiePrice[$type];
  $price = $noOfBoxes * $unitPrice;
  print "<tr><td>$type</td><td>$unitPrice</td><td>";
  if (!preg_match("/^\d+$/", $noOfBoxes )) {
     print "<span class=\"error\">Incorrect! Need to be a number.</span>\n";
     print "<input type=\"text\" name=\"$type\" value=\"$noOfBoxes\"
            class=\"error\">";
     $incorrectInput = 1;
  } else {
     print "<input type=\"text\" name=\"$type\" value=\"$noOfBoxes\">";
  }
  print "</td><td>$price</td></tr>\n";
  $totalPrice += $price;
}
print "<tr><td>&nbsp;</td><td>&nbsp;</td><td>total price:</td><td>$totalPrice</td>\n";
print "</table>\n";
if ($incorrectInput == 1) {
   print "<h2 class=\"error\">You have incorrect entries. Please correct the mistake before hitting the confirm button!</h2>";
}
?>
<input type="submit" name="submit" value="confirm">
</form>
</body>
</html>
