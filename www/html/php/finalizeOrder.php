<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
foreach ($_REQUEST as $key => $value) {
   print "name=$key value=$value<br>";
}
extract($_REQUEST);
//$email=$_REQUEST['email'];
//$telephone=$_REQUEST['telephone'];
//$creditCardType=$_REQUEST['creditCardType'];
//$creditCardNo=$_REQUEST['creditCardNo'];
//$expireDate=$_REQUEST['expireDate'];
//$shippingAddress=$_REQUEST['shippingAddress'];

$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$dbLink = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$dbLink);
print "email=$email<br>";
$query="SELECT customerID FROM customer where email='$email'";
if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
   exit();
} else { 
   $num_rows = mysql_num_rows($result);
   if ($num_rows==0) {
      // $query="INSERT INTO customer (fullName, email, telphone,
      // creditCardType, creditCardNo, address) VALUES ('$name',
      // '$email', '$telphone', '$creditCardType', '$creditCardNo',
      // '$shippingAddress'";
      // do forgot ending ) alway forgot that !
      $query="INSERT INTO customer (fullName, email, telephone,
creditCardType, creditCardNo, address) VALUES ('$name', '$email',
'$telephone', '$creditCardType', '$creditCardNo', '$shippingAddress')";
       print "query=$query<br>";
      if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
      } elseif (mysql_affected_rows() == 1) {
         $query="SELECT customerID FROM customer where email='$email'";
         $result=mysql_query($query, $dbLink);
         $myrow=mysql_fetch_array($result);
         $customerID=$myrow[0];
         print "Insert result=$customerID<br>";
      } else {
         print 'rownumber==0?<br>';
      }
   } else {
      $myrow=mysql_fetch_array($result);
      $customerID=$myrow[0];
      print "customerID=$customerID<br>";
   }
}

// insert orderCustomer record

$query="INSERT INTO orderCustomer (customerID) VALUES ($customerID)";
mysql_query($query, $dbLink);
$orderID=mysql_insert_id();
printf("execute query=$query<br>Last inserted has id %d<br>\n", $orderID);
// $result=mysql_query("SELECT LAST_INSERT_ID()");
$result=mysql_query("SELECT * FROM orderCustomer where orderID=LAST_INSERT_ID()");
$myrow=mysql_fetch_array($result);
$msg= "Dear $name, <br>orderID=$myrow[0], customerID=$myrow[1], orderTime=$myrow[2]<br> Here is the list of order items:<br>";
print $msg;
$msg .= "<table class=\"alternate\"  bgcolor=\"#EDDFC9\" border=1><tr><th>orderID</th><th>itemName</th><th>unitPrice</th><th>noOfUnits</th></tr>"; 
$query="SELECT item FROM inventory";
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
      $itemList[$i]=$myrow[0];
   }
}
//$itemList=array('disk', 'dvd', 'printer', 'processor');
$i=0;
foreach ($itemList as $item) {
   $noOfItems=$_REQUEST["noOfItems$item"];  // need to use " instead '
   print "item=$item noOfItems=$noOfItems<br>";
   if ($noOfItems != 0) {
       // insert a record
       $unitPrice=$_REQUEST["priceOfItem$item"]; // should we trust it 
       $query="INSERT INTO orderTable (orderID, itemName, unitPrice, noOfUnits) VALUES ($orderID, '$item', $unitPrice, $noOfItems)";
       //$query="INSERT INTO orderTable (itemName, unitPrice, noOfUnits) VALUES ('$item', $unitPrice, $noOfItems)";
       print "query=$query<br>"; 
      $msg .=
"<td>$orderID</td><td>$item</td><td>$unitPrice</td><td>$noOfItems</td></tr>\n";
      if(!($result = mysql_query($query, $dbLink))) {
                // get error and error number
                $errno = mysql_errno($dbLink);
                $error = mysql_error($dbLink);
                print("ERROR $errno: $error<br>\n");
                exit();
      } else {
         print "item $item inserted<br>";
      } 
      // update inventory
      $query="SELECT amount FROM inventory WHERE item='$item'";
      $result= mysql_query($query, $dbLink);
      $myrow=mysql_fetch_array($result);
      $amount=$myrow[0];
      $amount -= $noOfItems; // should check if lower than inventory
      $query="UPDATE inventory SET amount=$amount WHERE item='$item'";
      $result= mysql_query($query, $dbLink);
   }
}
print "Order insertion complete<br>";
$msg .="</table>";

$to=$email;
//$subject="(phishing Email example anyone can fake the sender email) Your order was processed";
$subject="Your order was processed";
//$header="From: cs301@cs.uccs.edu\r\n" .
$header="From: PayPal@paypal.com\r\n" .
        "Mime-Version: 1.0\r\n" .
        "Content-type: text/html; charset=\"iso-8859-1\"\r\n\r\n"; 
mail($to, $subject, $msg, $header);
print $msg;

?>
</body>
</html>
