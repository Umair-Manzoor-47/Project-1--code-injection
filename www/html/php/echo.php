<html>
<body bgcolor="#EDDF99">
<center>
You have enter the following info from a form:
<?php
foreach($_REQUEST as $key=>$value) {
   print ("key=$key:  value=$value<br />\n");
}
?>
</body>
</html>
