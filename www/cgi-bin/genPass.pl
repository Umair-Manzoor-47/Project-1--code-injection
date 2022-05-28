#!/usr/bin/perl

open(IN, "passwd");
open(OUT, ">encpasswd");
while(<IN>) {
   chomp();  # tricky if not remove the end of line, it won't work!
   @fields=split(':');
   $passwd=$fields[1];
   $login=$fields[0];
   print "login=$login; passwd=$passwd\n";
   print OUT "$login\:".crypt($passwd, "\$6\$fyionly"), "\n";
   #print OUT "$login\:".crypt($passwd, "\$6\$rounds=500000\$fyionly"), "\n";
}
