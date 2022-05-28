#!/usr/bin/env python

import cgi
import csv
import os
import sys
import re
import smtplib
from email.mime.text import MIMEText

htmlHead='''Content-Type: text/html\n
<html><head><title>
Retrieve access key and secret key
</title></head>
<body>
'''
htmlTail='</body></html>'
resbody='''<h3>Here is your access key and secret key</h3>
your login: <b>%s</b><br>
your accessKeyID: <b>%s</b><br>
your secretAccessKey: <b>%s</b><br>
'''
reshtml=resbody+htmlTail

errhtml='<h3>credential check failed</h3>'+htmlTail
err2html='<h3>no access key</h3>'+htmlTail
err3html='<h3>Input login not valid!</h3>'+htmlTail

form=cgi.FieldStorage()
fullName=form['fullName'].value
login=form['login'].value
passwd=form['passwd'].value
print htmlHead
m=re.match(r"^[a-zA-Z0-9]{4,8}$", login)
if m is None:
	print err3html
	sys.exit()
# credential checking
csvFile=csv.reader(open('../data/CS526S2013Grade.csv', 'rb'))
found=0
for row in csvFile:
	#print "login=%s passwd=%s loginInFile=%s passwdInFile=%s<br>" % (login, passwd, row[1], row[2])
	if row[1]==login:
		if '#a' + row[2]== passwd:
			found=1
			print "credential ok<br>"
                        break;
if found == 0:
	print errhtml
else:
	csvFile2=csv.reader(open('../data/sgc.csv', 'rb'))
	found = 0
	for row in csvFile2:
		#print "user=%s keyid=%s secretKey=%s" % (row[0], row[1], row[2])
		if row[0]==login:
			keyid=row[1]
			secretKey=row[2] 
			print reshtml % (login, keyid, secretKey)
			break;
	else: 
		print err2html

print 'login=%s<br />'%login;
#mailcmd = 'echo \"%s  is provided with the aws keys.\" | mail -s \"request key from %s\" -c %s@uccs.edu cchow@uccs.edu' % (fullName, login, login);
#print 'mailcmd=%s<br />'%mailcmd;
#os.system(mailcmd);

sender = 'root@cs591.csnet.uccs.edu'
receiver = 'cchow@uccs.edu'
msg = MIMEText("test")
#msg = MIMEText(reshtml % (login, keyid, secretKey))
msg['Subject'] = 'Here is your AWS access key'
msg['From'] = sender
msg['To'] = receiver

# Send the message via our own SMTP server, but don't include the
# envelope header.
s = smtplib.SMTP('localhost')
s.sendmail(sender, [receiver], msg.as_string())
s.quit()
print msg
