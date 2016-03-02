<?php
///////////////////////////////////////////////////
//// Tunnel CMS Powerd By Morteza BAsij
//// Email: basij.morteza@gmail.com
///////////////////////////////////////////////////
$timestart = microtime(true); 

session_start();

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

include('config.php');
include("core/CMSController.php");
$appilication = new CMSController();
$appilication->run();

$timeend = microtime(true);
$loger = new Loger();
$loger->timetracker($timeend - $timestart);
?>