ServerLoad
==========

ServerLoad provides a tiny PHP script to determine the load on a Linux/Unix
machine. It executes the "uptime" command on a server to read the load 
averages for the last minute, 5 minutes, and 15 minutes, as well as the
number of days, the server has been up. These values are wrapped up into a
JSON object and returned for client-side evaluation.

Installation
============

Place the PHP file metrics/load.php in the desired server directory.

The script has been tested on
- Debian Linux 6.0.4
- Mac OS X 10.7.3

Execution
=========

If the server is configured properly to execute PHP scripts, accessing the 
URL should result in a cross site JSON object wrapped by the passed callback
function. Example:

Request: 
http://presenterry.com/metrics/load.php?callback=returnLoad

Answer:
returnLoad({"average1min":"0.10","average5min":"0.11","average15min":"0.12","updays":"59"})

Afterwards the client-side returnLoad callback can visualize or log the
load values.
