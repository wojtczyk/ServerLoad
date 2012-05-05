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
URL should result in a JSON object or a cross domain JSONP object wrapped by
the passed callback function. On success the "status" field contains "ok",
on failure "fail".

### Same Origin Request ###

If the calling JavaScript program resides in the same domain, a request
without a callback is sufficient.

Request: 
    http://www.yourdomain.com/metrics/load.php

JSON answer:
    {"SL":1,"status":"ok","average1min":"0.10","average5min":"0.11","average15min":"0.12","updays":"59"}

### Cross Domain Request ###

For a cross domain request, the calling JavaScript program needs to supply
a callback method. (Hint: jQuery.getJSON() takes care of this if you 
append '?callback=?' to the URL)

Request:
    http://www.yourdomain.com/metrics/load.php?callback=dataLoad

JSONP answer:
    dataLoad({"SL":1,"status":"ok","average1min":"0.10","average5min":"0.11","average15min":"0.12","updays":"59"})

Afterwards the client-side dataLoad callback can visualize or log the
load values.
