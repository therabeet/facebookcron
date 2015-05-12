<?php 
error_reporting(E_ALL);
error_reporting(E_ERROR || E_PARSE);
define('PDFCROWDUSER','boksiu2');
define('PDFCROWDAPI','7312e3147d427337b6072680bd44aa79');

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "contentio";
$connection = mysql_connect($db_servername,$db_username,$db_password);
$db = mysql_select_db($db_name);


if(!$connection)
{
	die(mysql_error());	
	}
	

if(!$db)
{
	die(mysql_error());	
	}

?>