<html>
<head>
<title>processing order</title>
<link href="http://walrus.uccs.edu/~cs3110/csnet.css" type="text/css" rel="stylesheet" />
<script>
function checkAll() {
   var isOK = true;
   //reset className to be empty witout error
   document.form1.email.className = "";
   document.form1.emailConfirmed.className = "";
   document.form1.password.className = "";
   document.form1.passwordConfirmed.className = "";
   document.getElementById('msg1').textContent = "";
   if (document.form1.email.value != document.form1.emailConfirmed.value) {
       isOK = false; 
       document.form1.email.className += " error";
       document.form1.emailConfirmed.className += " error";
       document.form1.emailConfirmed.value += " not same as email";
       document.getElementById('msg1').textContent = "email not the same; ";
   } 
   if (document.form1.password.value != document.form1.passwordConfirmed.value ) {
       isOK = false; 
       document.form1.password.className += " error2";
       document.form1.passwordConfirmed.className += " error2";
       document.getElementById('msg1').textContent += " password not the same";
   }
   return isOK;
}
</script>
</head>
<body>
<h2>
<img src="WikiLeaks_files/ja-main.jpg" alt="wikileaks logo"
longdesc="wikileaks logo">
<br />
Please enter the following registeration information:
</h2>
<span class="error" id="msg1"></span>
<table class="alternate"> 
<form method="POST" autocomplete="on" name="form1"
      action="https://<?php echo $_SERVER['HTTP_HOST'] ?>/php/registerDB.php">
<tr><td>Full Name:</td>
<td>
<input type="text" name="fullName" size="50" value="Edward Chow">
</td></tr>
<tr><td>Email:</td><td>
<input type="email" name="email" required="required"  size="50" 
       value="cs3110@uccs.edu">
</td></tr>  
<tr><td>EmailConfirmed:</td><td>
<input type="email" name="emailConfirmed" required="required"  size="50" 
       value="cs3110@uccs.edu">
</td></tr>  
<tr><td>Password:</td><td>
<input type="password" name="password" required="required"  size="50" 
       value="cs07web">
</td></tr>  
<tr><td>PasswordConfirmed:</td><td>
<input type="password" name="passwordConfirmed" required="required"  size="50" 
       value="cs07web">
</td></tr>  
</table>
<input type="submit" name="submit" value="register" onClick="return checkAll();">
</form>
</body>
</html>
