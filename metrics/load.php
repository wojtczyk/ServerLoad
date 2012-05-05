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

// server load version
$slversion = 1;
// status "ok"|"fail"
$status = "ok";

// get server load
$loadresult = @exec('uptime');

// get averages
$average1min = 0.0;
$average5min = 0.0;
$average15min = 0.0;
$updays = 0;

// match regular expression to read the load averages for the past minute, 5 minutes, and 15 minutes
if ($matches = preg_match_all("/averages?: ([0-9\.]+)[\,\s]+([0-9\.]+)[\,\s]+([0-9\.]+)/", $loadresult, $averages))
{
	$average1min = $averages[1][0];
	$average5min = $averages[2][0];
	$average15min = $averages[3][0];

	// get server uptime
	$updaysArray = explode(' up ', $loadresult);
	$updaysArray = explode(' day', $updaysArray[1]);
	$updays = $updaysArray[0];
}
else 
{
	$status = "fail";
}

$data = array
(
	'SL' => $slversion,
	'status' => $status,
	'average1min' => $average1min,
	'average5min' => $average5min, 
	'average15min' => $average15min, 
	'updays' => $updays
);

if (isset($_GET['callback']))
{
	// return JSON data and allow cross domain access through callback
	echo $_GET['callback'].'('.json_encode($data).')';
}
else
{
	// return JSON data
	echo json_encode($data);
}
?>