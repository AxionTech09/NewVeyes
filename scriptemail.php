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
// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/processcontrol/retail-data/scriptemailhistory/");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);
?>