#!/usr/bin/perl

my $encrypted_password = "ww4uF4R2VdIcI"; # "badpassword"

print "Please enter the password:n";
chomp(my $input = <STDIN>);

if (crypt($input,$encrypted_password) eq $encrypted_password) {
    print "Correct password!n";
}
else {
    print "Access Deniedn";
} 
