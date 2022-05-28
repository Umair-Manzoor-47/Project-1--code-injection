#!/usr/bin/perl

#@hosts=qw(sanluis blanca crestone shavano wetterhorn);
$host="viva";
$rootdbpasswd=$ARGV[0];
$class=$ARGV[1];
$semester=$ARGV[2];

print "class=$class; semester=$semester\n";

open(LIST, "/home/chow/bin/$class".$semester."Grade.txt");
<LIST>; # skip title line
while (<LIST>) {
	chomp();
   ($name, $login, $sid)=split(/\t/);
	print "login=$login, sid=$sid, ";
	
$passwd=$sid;
print "passwd=$passwd\n";
open(OUT, ">acc.sql");
print OUT <<END;
create database $login\db;
GRANT all privileges on $login\db.* to $login\@localhost identified by '$passwd';
#GRANT all privileges on $login\db.* to $login\@walrus.uccs.edu identified by '$passwd';
END

close(OUT);

# the following code spread the users to a group of mysql servers
# we are not doing here. only use walrus
#$lastDigit=substr($passwd, 3,1);
#$hostIndex=$lastDigit%5;
#print "lastDigit=$lastDigit, hostIndex=$hostIndex\n";
#foreach $host (@hosts) {
#$host=$hosts[$hostIndex];
   print "host=$host\n";

   print "mysql -u root -p$rootdbpasswd -B < acc.sql > output.txt\n";
   system("mysql -u root -p$rootdbpasswd -B < acc.sql > output.txt");
   print "rm acc.sql\n";
   system("rm acc.sql");
}
