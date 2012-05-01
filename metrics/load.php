<?php
/******************************************************************************
* load.php
*
* Created on: Apr 27, 2012
* Copyright (C) 2011 Martin Wojtczyk <martin.wojtczyk@gmail.com>
*
* Description:
* 	  load.php is a tiny PHP script to determine the load on a Linux/Unix
* machine. It executes the "uptime" command on a server to read the load 
* averages for the last minute, 5 minutes, and 15 minutes, as well as the
* number of days, the server has been up. These values are wrapped up into a
* JSON object and returned for client-side evaluation. For installation just
* place the PHP file in the desired directory.  
******************************************************************************/

header("content-type: application/json");

// get server load
$loadresult = @exec('uptime');

// get averages
$average1min = "";
$average5min = "";
$average15min = "";

// match regular expression to read the load averages for the past minute, 5 minutes, and 15 minutes
if ($matches = preg_match_all("/averages?: ([0-9\.]+)[\,\s]+([0-9\.]+)[\,\s]+([0-9\.]+)/", $loadresult, $averages))
{
	$average1min = $averages[1][0];
	$average5min = $averages[2][0];
	$average15min = $averages[3][0];
}

// get server uptime
$updaysarr = explode(' up ', $loadresult);
$updaysarr = explode(' day', $updaysarr[1]);
$updays = $updaysarr[0];

$data = array
(
	'average1min' => $average1min,
	'average5min' => $average5min, 
	'average15min' => $average15min, 
	'updays' => $updays
);

// return JSON data and allow cross site access through callbacks
echo $_GET['callback'].'('.json_encode($data).')';
?>