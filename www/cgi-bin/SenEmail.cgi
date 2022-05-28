#!/usr/bin/perl
use CGI qw(:standard);
use Mail::Sendmail;

print header,start_html('Sending Email'),h1('Testing sending email');
%mail = ( To=> "cchow\@uccs.edu", From => "cs3110\@uccs.edu",Subject => "send test Sendmail by cs3110 to cchow", Message => "It is working !");
sendmail(%mail) or die $Mail::Sendmail::error;
print "OK. Log says:\n", $Mail::Sendmail::log;
print end_html;
