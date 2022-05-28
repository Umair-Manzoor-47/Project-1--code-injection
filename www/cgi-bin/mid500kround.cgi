#!/usr/bin/perl

#------------------------------------------------------------------------
# Author: C. Edward Chow
# Date:   22 December 1995
# Draft:  1.0
# Simple Perl script to save midterm answer
#------------------------------------------------------------------------

# Make sure use GET instead Get or get on the following matching string

if ($ENV{'REQUEST_METHOD'} eq "GET") { $buffer = $ENV{'QUERY_STRING'}; }
else { read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'}); }

print "Content-type: text/html\n\n";
print "<HTML><HEAD>\n";
print "</HEAD><BODY BGColor=\"#ffd39b\" TEXT=\"#2222222\">\n";
@nvpairs = split(/&/, $buffer);
foreach $pair (@nvpairs)
{
    ($name, $value) = split(/=/, $pair);

    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    if ($name ne 'passwd') { print "name=$name, value=$value<br>"; }
    $answers{$name} = $value;
}

$name = $answers{'name'};
$login = $answers{'login'};
$passwd = $answers{'passwd'};
$examine = $answers{'exam'}; # consist of class, semester, midterm/final
$class=substr($examine, 0, 5);
$semester=substr($examine, 5, 1);
$year=substr($examine, 6, 4);
$term=substr($examine, 10, length($examine)-10);
print "class=$class, year=$year, semester=$semester term=$term<br>";
print "login=$login, passwd=$passwd<br>\n";
system("mkdir ../html/midterm/$class");
system("mkdir ../html/midterm/$class\/$examine");

print "<h2>$examine submitted by $name</h2>\n";
open(IN, "encpasswd");
$found = 0;
while (<IN>) {
    if (/$login/) {
        chomp();
        @fields = split(/:/);
        $encryptedPasswd = $fields[1];
        @encFields = split(/\$/, $encryptedPasswd);
        print "id=$encFields[1]; salt=$encFields[2]; enc=$encFields[3]\n<br />";
	print "login=$login; encryptedPasswd=$encryptedPasswd; passwd=$passwd<br >\n";
        #$fullname = $fields[5];
	$found = 1;
        last;
    }
}
if ($found == 0) {
    print "login not correct!";
    die;
}
$try = 1;
while ($try) {
   #if (crypt($passwd, 'sa') eq $encryptedPasswd) {
   $res=crypt($passwd, "\$".$encFields[1]."\$".$encFields[2]);
   print "res=$res<br />res=$encryptedPasswd<br />\n";
   if ($res eq $encryptedPasswd) {
   #if ($passwd eq $passwdInFile) {
      print "login correct!\n"; 
      last;
   } else {
      print "password not correct!";
      die;
   }
}
close(IN);
#create unique file name
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$mon++;  # month is 0 indexed
$filename = "$login\_$year\_$mon\_$mday\_$hour\_$min\_$sec";

$file= "../html/midterm/$class\/$examine\/$filename";
if (open my $fh, '>', $file) {
    # open was successful
    print $fh $buffer;
    print "open $file success and content out<br />\n";
} else {
    # open failed - handle error
    print "open $file failed<br />\n";
}
#open(OUT, ">$class\/$examine\/$filename");
#print OUT $buffer;
close(OUT);
$command="/bin/mail -s \'$examine from " . $login . "\' -c $login\@uccs.edu cchow\@uccs.edu < $class\/$examine\/$filename";
system("$command");
print "$command\n";
print "</BODY></HTML>"; 
