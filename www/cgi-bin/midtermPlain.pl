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
$examine = $answers{'class'}; # consist of class, semester, midterm/final
$class=substr($examine, 0, 5);
$semester=substr($examine, 5, 1);
$year=substr($examine, 6, 4);
$term=substr($examine, 10, length($examine)-10);
print "class=$class, year=$year, term=$term<br>";
mkdir $class if -e $class;
mkdir "$class\/$examine" if -e "$class\/$examine";

print "<h2>$examine submitted by $name</h2>\n";
if (auth($username, $password)) {
      $search = 1; #pass!
} else {
      $search=0; #fail
      print "password not correct! <hr>\n";
      exit(1);
}
#create unique file name
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$mon++;  # month is 0 indexed
$filename = "$login\_$year\_$mon\_$mday:$hour:$min:$sec";
open(OUT, ">$class\/$examine\/$filename");
print OUT $buffer;
close(OUT);
$command="/bin/mail -s \'$examine from " . $login . "\' -c $login\@cs.uccs.edu chow\@cs.uccs.edu < $class\/$examine\/$filename";
system("$command");
print "$command\n";
print "</BODY></HTML>"; 

sub auth {
  my ($username, $password) = @_;
  open(IN, "CS522F2003Passwd.txt");
  while(<IN>) {
     if (/$username/) {
        # find  the line with the username
        @entry = split(/:/);
        if ($password == $entry[1]) {
            # password correct
            return 1;
        }
        return 0;
     }
  }
  return 0;
}

