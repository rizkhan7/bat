<?
if(isset($_GET['bat_debug']))
{
  if($_GET['bat_debug'] == "yes")
  {
  	$_SESSION['show_debug'] = "yes";
  }
  else
  {
  	$_SESSION['show_debug'] = "no";
  }
}
?>