<html>
<head>
<link href="../csnet.css" type="text/css" rel="stylesheet">
<title>Catalog Order Form</title>
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
//'processor', 'memory', 'disk', 'printer', 'dvd'];
?>
]
re = /^\d+$/;
function isANatureNumber(s) {
   if (re.test(s)) 
      if  (parseInt(s) >= 0) {
          return true;
      } else {
          return false;
      }
   else 
      return false;
}
function checkBoxNo(item, warning) {
   // try if (!isanatureNumber(item.value)) {
   // javascript is case sensitive
   if (!isANatureNumber(item.value)) {
      if (warning)
          // make sure "" string in one line otherwise get "unterminated
          // string constant msg on browser
         alert(item.name+" contain "+item.value+" and is not a nature number");
      return false;
   } 
   return true;
}
function checkAllBoxNo() {
   for (var i=0; i< <?php print $num_rows ?>; i++) {
       alert("processing order of "+document.myform.elements[i].name);
         if (!checkBoxNo(document.myform.elements[i], false)) {
           alert(document.myform.elements[i].name+" contains "+
                document.myform.elements[i].value+
               " and it is not a legal box number");
           return false;
         }
   }
   return true; 
}
function setTotal(){
   var sum = 0.0;
   for (var i=0; i< <?php print $num_rows ?>; i++) {
      var price=document.getElementById('priceOf'+cookies[i]).innerHTML;
      sum += price*document.myform.elements[cookies[i]].value;
   }
   document.myform.total.value = sum;
   //alert("sum="+sum);
}
</script>
</head>
<body>

<h1> jscatalogDB.php </h1>

<form method="POST" name="myform" action="processOrder.php" 
      onSubmit="return checkAllboxNo();">
<b>
<p>Please enter the number of the items you like to order</p>
<!-- \" is a mistake <TABLE border=1 BGCOLOR=\"#EDDFC9\"> it show green
 -->
<TABLE border=1 BGCOLOR="#EDDF99">
<TR><TH>Type of Items</TH><TH>Unit Price</TH><TH>No. of Items in Inventory</TH><TH>No. of Items to purchase</TH></TR>

<?php
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
// see looping example in http://www.w3schools.com/php/php_looping.asp
$i=0;
foreach ($cookies as $type) {
  $availableNoOfBoxes = $cookieJug[$type];
  $price = $cookiePrice[$type];
  $suggestedPurchase=ceil($availableNoOfBoxes/10);
  if ($i++%2 == 0) {
     print '<tr bgcolor="#93EEFF">';
  } else {
     print '<tr bgcolor="#93FFAA">';
  }
  print "<TD align=center>$type</TD><TD align=right id=priceOf$type>$price</TD><TD align=right>$availableNoOfBoxes</TD><TD align=right><INPUT type=text name=$type value=$suggestedPurchase style=text-align:right size=22 onChange=\"checkBoxNo(this,true);\"></TD></TR>\n";
}
?>
<TR><TD>&nbsp</TD><TD>&nbsp</TD><TD
style=text-align:right;font-weight:bold>TOTAL</TD><TD align=right><INPUT type=text name=total style=text-align:right size=22></TD><TR>
</TABLE>
<input type="button" value="Calculate" onClick="setTotal();">
<input type="submit" value="order">
</form>
</body>
</html>
