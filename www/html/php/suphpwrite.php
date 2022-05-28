<?php
$myfile=fopen("test.txt", "w");
fputs($myfile, "This is a test");
fclose($myfile);
?>
