<html>
<head>
<title>confirm processing order</title>
<link href="../csnet.css" type="text/css" rel="stylesheet">
<script>
var cookies = [
<?php
//
// the following code retrieves inventory table and save the item list
// to $items and $inventory
//
$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
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
</script>
</head>
<body>
<h1>Confirm Purchase Order</h1>
<hr>


<form method="Post"
      action="https://chow.csnet.uccs.edu/php/finalizeOrder.php">
<!-- Not that we are submitting credit info, we need to use https to make sure 
     the critical info will not be snatched by crackers -->
<?php

print "Here is what you have ordered. Hit \"finalize\" button to conclude the purchase.<br>\n";
print "<table class=\"alternate\" border=\"1\">\n";
print "<tr><th>Type of Item</th><th>Unit Price</th><th>Number of
Items</th><th>Subtotal</th></tr>\n";
$incorrectInput = 0;
foreach ($cookies as $type) {
  $noOfBoxes = $_REQUEST[$type];
  $unitPrice = $cookiePrice{$type};
  $price = $noOfBoxes * $unitPrice;
print "<tr><td align=center>$type</td><td align=right>$unitPrice</td><td
align=right>";
  if (!preg_match("/^\d+$/", $noOfBoxes )) {
     print "<span class=\"error\">Incorrect! Need to be a
number.</span>\n";
     print "<input type=\"text\" name=\"$type\" value=\"$noOfBoxes\" class=\"error\">";
     $incorrectInput = 1;
  } else {
     print "<input type=\"text\" name=\"$type\" value=\"$noOfBoxes\">";
  }
  print "</td><td align=\"right\">$price</td></tr>\n";

  $totalPrice += $price;
  print "<input type=\"hidden\" name=\"noOfItems$type\" value=\"$noOfBoxes\">\n";
  print "<input type=\"hidden\" name=\"priceOfItem$type\" value=\"$unitPrice\">\n";
}
print "<tr><td>&nbsp;</td><td>&nbsp;</td><td align=right>total price:</td><td>$totalPrice</td>\n";
print "</table>\n";

if ($incorrectInput == 1) {
   print "<h2 class=\"error\">You got incorrect input! The web page will return to previous web page in 5 seconds. If it didn't, please click the \"back\" button to go back to last web page to correct the mistake.</h2>\n";
   print "<meta http-equiv=\"Refresh\" content=\"5; URL=http://walrus.uccs.edu/~cs3110/php/processOrder.php?";

   foreach ($cookies as $type) {
      $noOfBoxes = $_REQUEST[$type];
      print "$type=$noOfBoxes&"; /* this is part of name-value pair inputs */
   }
   print "\">";
   print "</form></body></html>";
   return;
}
?>

<P>
<a name="account">
Please enter the following order information:
<table class="alternate"> 
<tr><td>Full Name:</td><td><input type="text" name="name"
size="30" value="Edward Chow"></td></tr>
<tr><td>Email:</td><td><input type="text" name="email"
size="30" value="cchow@uccs.edu"></td></tr>  
<tr><td>Telephone (include area code no space () or - ):</td><td><input type="text" name="telephone"
size="30" value="7192553110"></td></tr>
<tr><td>Credit Card Type:</td>
    <td><select size="1" name="creditCardType">
	     <option selected>Visa</option>
	     <option>Master</option>
	     <option>American Express</option>
	     <option>Discover</option>
	</select>
</td><tr>
<tr><td>Credit Card # (no dash or space):</td><td><input type="text"
name="creditCardNo" size="20" value="1111222233334444"></td></tr>
<tr><td>Expiration Date:</td><td><input type="text"
name="expireDate" size="5" value="02/16"></td></tr>
<tr><td>Shipping Address:</td>
    <td><textarea name="shippingAddress" rows="4" cols="28">
1420 Austin Bluffs Parkway
Colorado Springs, CO 80918
</textarea>
    </td>
	 </tr>
</table>
<input type="submit" name="submit" value="Finalize">
</form>
</body>
</html>
