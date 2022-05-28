#!/usr/bin/perl

$rootdbpasswd=$ARGV[0];
$login=$ARGV[1];
$passwd=$ARGV[2];

# @hostlist=qw(blanca sanluis crestone wetterhorn redcloud shavano);
#`foreach $host (@hostlist) {

open(OUT, ">acc.sql");
print OUT <<END;
GRANT all privileges on $login\db.* to $login\@localhost identified by '$passwd';
#GRANT all privileges on $login\db.* to $login\@'%' identified by '$passwd';
#GRANT all privileges on $login\db.* to $login\@$host.uccs.edu identified by '$passwd';
flush privileges;
create database $login\db;
END

close(OUT);

#system("mysql -u root -p$rootdbpasswd -h $host -B < acc.sql > output.txt");
system("mysql -u root -p$rootdbpasswd -B < acc.sql > output.txt");
system("rm acc.sql");
#}
