<html>
<body bgcolor="#EDDF99">
<center>
<form action="showUserDB.php" method="post">
Select Database and Table for display:<BR>

<?php
extract($_REQUEST);
if (!$user) {
   $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$host="localhost";
} else {
   $database=$user . "db";
   print "database=$database<br>";
}
$db = mysql_connect($host, $user, $passwd);
print ("User:<input type=text name=\"user\" value=\"$user\"><BR>"); 
print ("Password:<input type=\"password\" name=\"passwd\" value=\"$passwd\"><BR>"); 
print ("Host:<input type=text name=\"host\" value=\"$host\"><BR>"); 
?>

Table:<select name="table">
<?php
$result=mysql_list_tables($database, $db);
$i = 0;
while ($i < mysql_num_rows ($result)) {
   $tb_names[$i] = mysql_tablename($result, $i);
   if ($tb_names[$i] == $table) {
      print ("<option selected> $tb_names[$i]</option>\n");
   } else {
      print ("<option>$tb_names[$i]</option>\n");
   }
   $i++;
}
print ("</select>\n");
if (!$table) {
    $table=$tb_names[0];
}
?>

<BR><input type=submit value="Get DB Table">
</form>

<?php
$db = mysql_connect($host, $user, $passwd);
mysql_select_db($database,$db);
$result = mysql_query("SELECT * FROM $table",$db);
$num_fields = mysql_num_fields($result);
print ("<P><B>$table Table Content</B>\n<P><table bgcolor=\"#EDDFC9\" border=\"1\" cellspacing=\"2\"><tr>");
for ($i=0; $i<$num_fields; $i++) {
   printf ("<th>%s</th>", mysql_field_name($result, $i));
}
print ("</tr>\n");
while ($myrow = mysql_fetch_array($result)) {
   if ($i++%2==0) {
      print ("<tr bgcolor=\"#93EEFF\">");
   } else {
      print ("<tr bgcolor=\"#93FFAA\">");
   }
   for ($j=0; $j<$num_fields; $j++) {
      printf("<td>%s</td>", $myrow[$j]);
   }
   print ("</tr>\n");
}      
print ("</table></center>");
?>

</body>
</html>
