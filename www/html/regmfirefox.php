<html>
<head>
<title>membership registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<intercept-url pattern="/favicon.ico" access="ROLE_ANONYMOUS" />
<link type="text/css" href="http://code.jquery.com/mobile/latest/jquery.mobile.min.css" rel="stylesheet" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/mobile/latest/jquery.mobile.min.js"></script>
<style>
.error { background-color:#FFDDDD; font-size: 14pt; color:#FF4444 }
.alert { background-color:yellow; font-size: 14pt; color:red }
.ui-hidden-accessible { display:none; }
</style>
</head>
<body>
<div data-role="page" id="first" data-theme="a" data-transition="slide" data-direction="reverse">

<div data-role="header">
<h2>
Cyber Club Registration Web Page
</h2>
</div><!-- /header -->

<div data-role="content"> 
Please Enter Registration Info:
<div class="ui-field-contain">
<form method="POST" autocomplete="on" name="form1"
      action="https://<?php echo $_SERVER['HTTP_HOST'] ?>/php/regk.php">
<label for="fullName" class="ui-hidden-accessible">Full Name:</label>
<input name="fullName" id="fullName" placeholder="Full Name" value="" type="text">
<label for="email" class="ui-hidden-accessible">Email:</label>
<input name="email" id="email" placeholder="Email" type="text">
<label for="emailConfirmed" class="ui-hidden-accessible">EmailConfirmed:</label>
<input name="emailConfirmed" id="emailConfirmed" placeholder="EmailConfirmed" type="text">
<label for="password" class="ui-hidden-accessible">Password:</label>
<input name="password" id="password" placeholder="Password" type="password">
<label for="passwordConfirmed" class="ui-hidden-accessible">PasswordConfirmed:</label>
<input name="passwordConfirmed" id="passwordConfirmed" placeholder="PasswordConfirmed" type="password">
<input type="submit" name="submit" value="Submit" onClick="return checkAll();">
</form>
</div>
</div><!-- /content -->

<div data-role="footer">
<h2>@copyleft 2016:  Cyber Club  Registration Web Form</h2>
</div><!-- /page -->
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
