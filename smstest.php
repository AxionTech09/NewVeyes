<?php
/*
Make wamp server to run on system startup
-run -> services.msc
-wampapache -> right click properties set statup type to automatic
-wampmysqld -> right click properties set statup type to automatic
-restart the system

Scheduling Script
-Open Task Scheduler from windows Start menu
-Go to Action menu and hit Create Task...
-in General tab, fill the Name and Description fields as you want
-in Triggers tab, hit New button.
-from Begin the Task dropdown, select On a schedule and choose Daily
-from Advanced settings section, select Repeat task every as you want and set for a duration on Indefinitely.
-on Actions tab, from Action dropdown, select Start a program.
-on the Program\script box, enter path to php path like -> C:\wamp\bin\php\php5.5.12\php.exe
-on the Add arguments section, enter script path like -> -f  C:\wamp\www\processcontrol\scriptemail.php

or

Use System Scheduler Software and input values as above.

*/
$username = "axionins";
$password = "axion123";
$sendername = "TAINSC";
$message = "Testing";
$url = "http://bulksms.mysmsmantra.com/WebSMS/SMSAPI.jsp?username=$username&password=$password&sendername=$sendername&mobileno=$mobileno&message=$message";

$useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2';

$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_COOKIEJAR, 'C:\wamp\www\processcontrol\tmp\cookies.txt');
//curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\wamp\www\processcontrol\tmp\cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // required as godaddy fails
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // required as godaddy fails
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

$html = curl_exec($ch);

//print $html;

if(!$html){
    echo "cURL error number:" .curl_errno($ch);
    echo "cURL error:" . curl_error($ch);
}

curl_close($ch);
?>
