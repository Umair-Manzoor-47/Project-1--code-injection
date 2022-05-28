#!/usr/bin/perl
use CGI qw(:standard);

print header();
print start_html(-title=>'Sendmail demo', -bgcolor=>'#DD9999'),
      h1('Sendmail demo');
print end_html;
