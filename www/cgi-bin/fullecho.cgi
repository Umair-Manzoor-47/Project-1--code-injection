#!/usr/bin/perl
use CGI qw(:standard);

#print header();
print "Content-Type: text/html\n\n";
print start_html('Echo name=value list');
print "<h1>Echo name value pair list </h1>";
print hr;
@names = param;
foreach $name (@names) {
	$value = param($name);
	print "$name=$value<br>";
}
print "</body></html>";
