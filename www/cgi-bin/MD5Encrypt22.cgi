#!/usr/bin/perl
use strict;
use Crypt::PasswdMD5 qw(unix_md5_crypt);
my @salt = ( '.', '/', 0 .. 9, 'A' .. 'Z', 'a' .. 'z' );
# this takes password as argument: good for simple example, bad for
# security (perldoc -q password)
my $password = shift || die "usage: $0 password";
my %encrypted;
# generate traditional (weak!) DES password, and more modern md5
$encrypted{des} = crypt( $password, gensalt(2) );
$encrypted{md5} = unix_md5_crypt( $password, gensalt(8) );
print "$_ $encrypted{$_}\n" for sort keys %encrypted;
     
# uses global @salt to construct salt string of requested length
sub gensalt {
my $count = shift;
my $salt;
for (1..$count) {
$salt .= (@salt)[rand @salt];
}
return $salt;
} 
