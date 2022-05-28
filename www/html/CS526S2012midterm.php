<!doctype html public "-//w3c//dtd html 4.0 transitional//en">

<html>

<head>

   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

   <meta name="Author" content="C. Edward Chow">

   <meta name="GENERATOR" content="Mozilla/4.7 [en] (WinNT; I) [Netscape]">

   <link href="http://cs.uccs.edu/~cs526/csnet.css" rel="stylesheet" type="text/css">

   <title>CS526 S2012  Midterm Test Web page</title>

   <style type="text/css">

<!--

.section {background-color:#FFDDDD; font-size: 18pt; color:#FF4444 }

-->

   </style>

</head>

<body>

<center>

    <table border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td><img src="http://cs.uccs.edu/~cs526/images/cs526logo.jpg" alt="cs526 logo"

longdesc="CS526 logo"></td>

      </tr>

      <tr>

        <td><img SRC="http://cs.uccs.edu/~cs526/rainbowan.gif" alt="rainbow animatio" width=100% height=12></td>

      </tr>

    </table>

</center>

  <center>
    <h2><font face="Arial,Helvetica">CS526 S2012 Midterm Exam</font></h2>
</center>
  <p><font face="Arial"> Please enter your UFP count login and the student 
    ID without dash as password and submit the midterm before 10am 3/15/2012.&nbsp;&nbsp; You 
    can work at home or at PC lab where you can access it through a web browser.&nbsp; 
  For multiple-choice questions, you must choose either yes or no for each answer.</font>
<p><font face="Arial">After filled in the answers in the text areas and selected 
    the answers, please print a copy (print to a pdf file will save tree:-)) of the web page with your answers before you 
    hit the submit button. Note that "save file" menuitem does not save the data 
    you enter. It only saves the HTML source file. Submit your answers by pressing 
    the submit button at the end of this web page.&nbsp; You will get a confirm 
    web page and an email with all your answers. Make sure you see &quot;<span class="eceBGcolor">login correct</span>&quot; in the bottom of the response web page. If you have problem getting the confirm web page or 
    submitting midterm answers using the web page, just email me the answers. </font><br>
  <form action="http://<?php echo $_SERVER['HTTP_HOST'] ?>/cgi-bin/midterm.cgi" method=post>
    <input type=hidden name="exam" value="CS526S2012midterm">
    <center>
      <table BORDER WIDTH="100%" >
        <tr>
          <td><font face="Arial">Your name:</font></td>
          <td><input type=text name="name" size=40>          </td>
        </tr>
        <tr>
          <td><font face="Arial">Your login on UCCS UFP account:</font></td>
          <td><input type=text name="login" size=40>          </td>
        </tr>
        <tr>
          <td><font face="Arial">Your password (your SID without dash):</font></td>
          <td><input type=password name="passwd" size=40>          </td>
        </tr>
      </table>
    </center>
    <p>.
    <hr WIDTH="100%">
    <ol>
      <li> <font color="#FF0000"><a href="http://cs.uccs.edu/%7Ecs526/apache/apache.ppt">Apache</a></font></li>
      <ol type=a>
        <li> Web Server Configuration</li>
        <ol>
          <li> What <a href="http://httpd.apache.org/docs/2.2/mod/quickreference.html">directives of the httpd server</a> are related to the feature of adapting to the dynamic nature of the incoming traffic and resulting faster response time? </li>
          <ol type="a">
            <li>MinSpareThreads.   
            <input type=radio name="1a1a" value="yes"> Yes
            <input type=radio name="1a1a" value="no">  No
            </li>
            <li>MaxSpareServers.
            <input type=radio name="1a1b" value="yes"> Yes
            <input type=radio name="1a1b" value="no">  No
            </li>
            <li>Allow. 
             <input type=radio name="1a1c" value="yes"> Yes
            <input type=radio name="1a1c" value="no">  No 
            </li>
            <li>TransferLog. 
             <input type=radio name="1a1d" value="yes"> Yes
            <input type=radio name="1a1d" value="no">  No 
            </li>
          </ol>
          <li>Explain why httpd would like to kill spare threads or spare child processes after reaching peak burst of requests?
          <br>
            <textarea name="1a2" cols=80 rows=5></textarea>
          </li>
          <li>What factors impact the selection of  the MaxSpareThreads value?
            <ol type="a">
              <li>Main memory of the server.
              <input type=radio name="1a3a" value="yes"> Yes
            <input type=radio name="1a3a" value="no">  No
              </li>
              <li>The number of cores in the server processor.
              <input type=radio name="1a3b" value="yes"> Yes
            <input type=radio name="1a3b" value="no">  No
              </li>
            </ol>
          </li>
          <li>Are these directives configured right?<br>
            <ol type="a">
            <li>
            User root 
			<input type=radio name="1a4a" value="yes"> Yes
            <input type=radio name="1a4a" value="no">  No
            </li>
            <li>MaxRequestsPerChild  0 
            <input type=radio name="1a4b" value="yes"> Yes
            <input type=radio name="1a4b" value="no">  No
          </li>
          <li>Allow 128.198.50.0/24 128.198.49
            <input type=radio name="1a4c" value="yes"> Yes
            <input type=radio name="1a4c" value="no">  No
          </li>
            </ol>
          </li>
          <li>KeepAlive 
            Directive.
            <ol type="a">
              <li>Reduce the TCP 3 way hand-shaking time for the follow-up requests such as embeded references of a html web page.<br>
			<input type=radio name="1a5a" value="yes"> Yes
            <input type=radio name="1a5a" value="no">  No
              </li>
              <li>Allow multiple requests to be sent over the same TCP connection.
            <input type=radio name="1a5b" value="yes"> Yes
            <input type=radio name="1a5b" value="no">  No
              </li>
              <li>Currently the browser can only send one request at a time over the keepAlive connection, and cannot send the next request until the reponse of the previous request is received.
            <input type=radio name="1a5c" value="yes"> Yes
            <input type=radio name="1a5c" value="no">  No
              </li>
            </ol>
          </li>
          <li>Authentication<br>
            <ol type="a">
            <li>
            For a website implements password protection using AuthType Basic directive, how to protect password from being stolen by a hacker that is observing/sniffing every packet between the client and the server. Short answer please. <input type=text name="1a6a" size=40></li>
            <li>Digest Authentication is more secure alternative to Basic Authentication. Because it uses PKI. 
            <input type=radio name="1a6b" value="yes"> Yes
            <input type=radio name="1a6b" value="no">  No
          </li>
          <li>The directives in the .htaccess file of a subdirectory will overwrite those directives in the  .htaccess files higher up in the directory tree.
            <input type=radio name="1a6c" value="yes"> Yes
            <input type=radio name="1a6c" value="no">  No
          </li>
          <li>The configuration directives for the client-based mutual athentication needs to be placed on the /etc/httpd/conf/httpc.conf to avoid the by-pass access through plain htttp request.
            <input type=radio name="1a6d" value="yes"> Yes
            <input type=radio name="1a6d" value="no">  No
          </li>
          <li>The private key file of a server needs to be decrypted otherwise the system will prompt for the passphrase that protects it.
            <input type=radio name="1a6e" value="yes"> Yes
            <input type=radio name="1a6e" value="no">  No
          </li>
          <li>If a browser indicates a server certificate presented by an online-banking site is ok, then we are absoluately not visiting a fake site.
            <input type=radio name="1a6f" value="yes"> Yes
            <input type=radio name="1a6f" value="no">  No
          </li>
          <li>A PKI based secure communication is based not just the autenticity of the certificates but also  those of related encryption software modules and browser software.
            <input type=radio name="1a6g" value="yes"> Yes
            <input type=radio name="1a6g" value="no">  No
          </li>
          <li>The subject field of a certificate can be used to allow the user associated with the certificate to access a secure site.
            <input type=radio name="1a6h" value="yes"> Yes
            <input type=radio name="1a6h" value="no">  No
          </li>
            </ol>
          </li>
        </ol>
      <li> Cache Server.<br>
            <ol>
              <li>Which  <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.3">HTTP request header </a>allows fast concurrent download of segments of a large iso file from mirror sites? <br /><input type=text name="1b1" size=40></li>
              <li>Which <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.3">HTTP request header </a>is used by client browser or cache server to ensure the content is not stale? <br /><input type=text name="1b2" size=40>
                <br>
              </li>
        <li>Akamai's Edge Server solution vs client side cache server solution.<br>
        <ol type="a">
            <li>Its edge server is closer to the clients and therefore faster.<br />
            <input type=radio name="1b3a" value="yes"> Yes
            <input type=radio name="1b3a" value="no">  No
            </li>
            <li>The client browsers do not have to be reconfigured to send reqeuests indirectly through the client side cache server therefore their accesses to Internet are faster. <br /> 
            <input type=radio name="1b3b" value="yes"> Yes
            <input type=radio name="1b3b" value="no">  No
            </li>
            <li>Akamai edge servers implement ESI scheme which allows them to assemble and serve web pages without consulting the original web server. Therefore they are faster than the client side cache server <br /> 
            <input type=radio name="1b3c" value="yes"> Yes
            <input type=radio name="1b3c" value="no">  No
            </li>
        </ol>
        </li>
        <li>Akamai's Edge Server solution vs Mirror Server solution.<br>
        <ol type="a">
            <li>Its edge server is closer to the typical mirror server and therefore faster.<br />
            <input type=radio name="1b4a" value="yes"> Yes
            <input type=radio name="1b4a" value="no">  No
            </li>
            <li>Mirror server service is free while there is cost associated with the use of Akamai Edge Servers. <br /> 
            <input type=radio name="1b4b" value="yes"> Yes
            <input type=radio name="1b4b" value="no">  No
            </li>
            <li>Mirror servers are owned and operated by different organizations and their availabilities are typically lower.<br /> 
            <input type=radio name="1b4c" value="yes"> Yes
            <input type=radio name="1b4c" value="no">  No
            </li>
        </ol>
        </li>
			  <li>Which technique is used to ensure the cached documents are evenly distributed in the apache httpd cache directory? <br>
              <ol type="a">
              <li>Hash the url and use it as the file path for a cached document.
              <input type=radio name="1b5a" value="yes"> Yes
            <input type=radio name="1b5a" value="no">  No
			  </li>
              <li> 
              Use the file size as the prefix of the file path for a cached document.
              <input type=radio name="1b5b" value="yes"> Yes
            <input type=radio name="1b5b" value="no">  No
              </li>
              </ol>
              </li>
          </ol>
        <br>
      </li>
      </ol>
<li> <font color="#FF0000">LVS</font></li>
      <ol type=a>
        <li>LVS-<a href="http://cs.uccs.edu/%7Echow/pub/conf/pdcat/tutorial.ppt#16">NAT</a>.</li>
        <ol>
          <li> The real server can be run at different port numbers than that known to the client?
            <input type=radio name="2a1" value="yes">  Yes
            <input type=radio name="2a1" value="no">    No
          </li>
            <li>The real server can send http response directly to the client without going through the director. <br />
            <input type=radio name="2a2" value="yes">  Yes
            <input type=radio name="2a2" value="no">    No
            </li>
        </ol>
        <li> <a href="http://www.austintek.com/LVS/LVS-HOWTO/HOWTO/LVS-HOWTO.ipvsadm.html#scheduler">LVS-Tunnel</a>.<br>
          <ol type="1">
          <li>
          The main advantages of using LVS-Tunnel is that the real servers can be spread out in internet and some can be closer to the clients. <br />
            <input type=radio name="2b1" value="yes">  Yes
            <input type=radio name="2b1" value="no">    No
          </li>
          <li>
          The TCP acknowlegment segments from a client still sent to the assigned real server through the director. <br />
            <input type=radio name="2b2" value="yes">  Yes
            <input type=radio name="2b2" value="no">    No
          </li>
          <li>
What are the two main disadvantage of a LVS-Tunnel configuration compared with the other two LVS configurations? <br>
                <textarea name="2b3" cols=80 rows=5></textarea>
                <br>
        </li>
        </ol>
        <li><a href="http://cs.uccs.edu/%7Echow/pub/conf/pdcat/tutorial.ppt#24"> LVS-Direct Routing</a><br>
           <ol>
           <li>What is the main reason why LVS-DR is the fastest one among the three basic configurations? Short answer please. 
             <input type=text name="2c1" size=40><br>
             </li>
             <li>
Why all real servers of LVS-DR cluster need to be in the same sub-LAN?<br>
          <textarea name="2c2" cols=80 rows=5></textarea>
          &nbsp;</li>
          
          </ol>
        </li>
        <li> LVS Performance. <br />
        <ol type="1">
        <li>A slow Pentium II machine can serve more than 1024 vip sites.<br />
        <input type=radio name="2d1" value="yes">  Yes
            <input type=radio name="2d1" value="no">    No
        </li>
        <li>A vip can be used to provide multiple network services. <br />
        <input type=radio name="2d2" value="yes">  Yes
            <input type=radio name="2d2" value="no">    No
        </li>
        </ol>
        </li>
        </li>
        </ol>
      <li>LCS
      <ol type="a">
      <li>What impact on the performance of a content switch? Names two important factors. <br />
       <textarea name="3a" cols=80 rows=5></textarea>
      </li>
      <li>
How can we speed up the performance of a content switche? Name two techiques.<br />
 <textarea name="3b" cols=80 rows=5></textarea>
</li>
<li>
What is TCP delayed binding? Name two ways to improve it? <br />
<textarea name="3c" cols=80 rows=5></textarea>

</li>
</ol>
</li>
</ol>
      
    </ol>
    <p>If you feel some of the questions are ambiguous, state the problem # and 
  your assumptions on the answers.<br>
        <textarea name="assumptions" cols=80 rows=5></textarea>
    </p>
    <input name="submit" type=submit value=submit>
  </form>
<h2>&nbsp;</h2>
</body>
</html>


