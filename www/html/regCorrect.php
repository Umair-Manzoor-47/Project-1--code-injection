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
Welcome to <a href="https://codebreaker.ltsnet.net/leaderboard">NSA Codebreaker</a> Training Registration Web Site!
<br />

Here we are using <a href="http://www.w3.org/TR/html-markup/input.html">HTML5 new input type controls</a>.
<br />
Please enter the following registeration information:
</h2>
<table class="alternate"> 
<form method="POST" autocomplete="on" name="form1"
      action="https://<?php echo $_SERVER['HTTP_HOST'] ?>/php/regCorrect.php">
<tr><td>Full Name:</td>
<td>
<input type="text" name="fullName" size="50" value="Porg Webb">
</td></tr>
<tr><td>Email:</td><td>
<input type="text" name="email" size="80" 
       value="cs3110@uccs.edu" >
</td></tr>  
<tr><td>EmailConfirmed:</td><td>
<input type="text" name="emailConfirmed" size="80" 
       value="cs3110@uccs.edu" >
</td></tr>  
<tr><td>Password:</td><td>
<input type="password" name="password" required="required"  size="50" 
       value="cs07web" >
</td></tr>  
<tr><td>PasswordConfirmed:</td><td>
<input type="password" name="passwordConfirmed" required="required"  size="50" value="cs07web" >
</td></tr>  
</table>
<input type="submit" name="submit" value="register" onClick="return checkAll();">
</form>
<script type="text/javascript">
$("input").on("change",
function checkAll() {
   var isOK = true; ema=$("[name='email']"); emc=$("[name='emailConfirmed']");
   var pwd=$("[name='password']"); pwdc=$("[name='passwordConfirmed']");
   if (ema.val() != emc.val()) {
    isOK = false; 
    ema.addClass("error");
    emc.addClass("error");
    if ($('.emailErrmsg').length==0) {
    ema.after('<div class="emailErrmsg alert">Email not matched</div>');
    }
   } else { 
    ema.removeClass("error");
    emc.removeClass("error");
    $('.emailErrmsg').remove();
   }
   if (pwd.val() != pwdc.val()) {
    isOK = false; 
    pwd.addClass("error");
    pwdc.addClass("error");
    if ($('.pwdErrmsg').length==0) {
    pwd.after('<div class="pwdErrmsg alert">Password not matched</div>');
    }
   } else { 
    pwd.removeClass("error");
    pwdc.removeClass("error");
    $('.pwdErrmsg').remove();
   }
   return isOK;
}
);
</script>
</body>
</html>
