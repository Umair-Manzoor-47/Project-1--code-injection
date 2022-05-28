#!/usr/bin/perl -w
#
# $Id: md5crypt,v 1.3 2006/03/10 09:02:52 mesrik Exp $
#
# BFMI unix_md5_crypt() usage sample and encrypted password generator
#
use strict;
use Crypt::PasswdMD5;
use Getopt::Long;
use Pod::Usage;

my ($passwd,$salt,$crypted);
my ($help,$man,$verbose,$vers,$version);

$0 =~ s/.*\///o; # weed the path
$version = '$Id: md5crypt,v 1.3 2006/03/10 09:02:52 mesrik Exp $';

GetOptions ('help|?'          => \$help,
            'man'             => \$man,
            'salt=s'          => \$salt,
            'verbose!'        => \$verbose,
            'version'         => \$vers
            ) or pod2usage(2);

die "$version\n" if ($vers);
pod2usage(1) if $help;
pod2usage(-verbose => 2) if $man;
pod2usage(1) unless (@ARGV);

# initialize
srand(time ^ $$ ^ unpack "%L*", `ps axww | gzip`);

foreach $passwd (@ARGV) {
    if (defined($salt)) {
	$crypted = unix_md5_crypt($passwd,$salt);
    } else {
	$crypted = unix_md5_crypt($passwd);
    }

    if ($verbose) {
        print $passwd, " ";
        print $salt," " if ($salt);
    }

    print $crypted, 
         ($crypted eq unix_md5_crypt($passwd,$crypted)) ? 
         "\n" : " INTERNAL ERROR: Doublecheck FAILURE!\n";

}