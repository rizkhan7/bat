<?
include_once "ini_includes.php";

// check if page var is defined, if not set a default
if(!isset($_GET['ct']))
{
	$_GET['ct'] = "home";
}

$renderfile = $_GET['ct'] . ".php";

if(!file_exists($renderfile))
{
	$renderfile = "home.php";
}

//to stop hacks if file_exists ever gets upgraded to check remote files!
if(stristr($renderfile,"http"))$renderfile = "home.php";

include_once "display_output.php";
?>