<html>
<body>
<?php

$long=$_GET['long'];
$lat=$_GET['lat'];

$host="localhost"; $user="chow"; $passwd="#Uc2013lions$"; $database="chowdb";
$mysqli = new mysqli($host, $user, $passwd, $database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
}

/* retrieve password */
/* Select queries return a resultset */
if (!$result = $mysqli->query("INSERT INTO PotHoles (long, lat)  value ('$long', '$lat')")) {
   die('There was an error running the query [' . $mysqli->error . ']');
}

print("long = $long<br />lat = $lat<br />\n");

?>
</body> </html>
