#!/usr/bin/perl
use CGI qw(:standard);
use Mail::Sendmail;

print header();
print start_html(-title=>'Sendmail demo', -bgcolor=>'#DD9999'), 
      h1('Sendmail demo'); 
%mail = ( To      => "cchow\@uccs.edu",
          From    => "root\@cs591.csnet.uccs.edu",
	  Subject => "send test Sendmail by edward to chow",
          Message => "This is a very short message"
        );
sendmail(%mail) or die $Mail::Sendmail::error;
print "OK. Log says:\n", $Mail::Sendmail::log;
print end_html;
