<html>
<head>
<title>membership registration</title>
<link href="csnet.css" type="text/css" rel="stylesheet" />
<style>
.error { background-color:#FFDDDD; font-size: 14pt; color:#FF4444 }
.alert { background-color:yellow; font-size: 14pt; color:red }
</style>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
<h2>
Here we are using <a href="http://www.w3.org/TR/html-markup/input.html">HTML5 new input type controls</a>.
<br />
Please enter the following registeration information:
</h2>
<table class="alternate"> 
<form method="POST" autocomplete="on" name="form1"
      action="https://<?php echo $_SERVER['HTTP_HOST'] ?>/php/regci.php">
<tr><td>Full Name:</td>
<td>
<input type="text" name="fullName" size="50" value="Ed Chow">
</td></tr>
<tr><td>Email:</td><td>
<input type="text" name="email" size="50" 
       value="cchow@uccs.edu" >
</td></tr>  
<tr><td>Password:</td><td>
<input type="password" name="password" required="required"  size="50" 
       value="1111" >
</td></tr>  
</table>
<input type="submit" name="submit" value="register" onClick="return checkAll();">
</form>
</body>
</html>
