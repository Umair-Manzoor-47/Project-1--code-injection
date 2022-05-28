<HTML>
<HEAD>
<?php
// a comment can be inserted like this
// designate some variables
$bgcolor = "cyan";
$textcolor = "green";
?>
<TITLE>First PHP example</TITLE>
<BODY <?php Print "bgcolor='$bgcolor' text='$textcolor'"; ?>>

<H3>A PHP-enabled page!!!</H3>

<?php echo $HTTP_USER_AGENT; ?>
<P>
<?php phpinfo()?>
<P>


      <?php 
      if(strstr($HTTP_USER_AGENT,"MSIE")) {
      ?>
      <center><b>You are using Internet Explorer</b></center>
      <?php
      } else {
      ?>
      <center><b>You are not using Internet Explorer</b></center>
      <?php
      }
      ?> 
<form action="action.php" method="POST">
      Your name: <input type=text name=name>
      You age: <input type=text name=age>
      <input type=submit>
      </form> 
</BODY>
</HTML>
