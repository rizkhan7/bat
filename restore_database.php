<?
//restores BAT Demo Database!

$db = mysql_connect ($app_database_server, $app_dbase_username, $app_dbase_password) or die('not connected');
mysql_select_db($app_database_name, $db) or create_bat_database();

if(isset($reconnect_to_bat) && $reconnect_to_bat == 1)
{
  echo "Retrying connection...<br><br>";
  
  include "ini_db_connect.php";
}

$FP = fopen('bat_demo_database.sql','r');
$READ = fread($FP, filesize('bat_demo_database.sql'));

batch_query($READ);

echo '<font color="green"><b>The BAT demo database has been created!</b></font>';

function create_bat_database()
{
  global $app_database_server,$app_database_name,$app_dbase_username,$app_dbase_password;
  
  echo "Creating BAT Demo Database...<br><br>";
  
  $con = mysql_connect($app_database_server,$app_dbase_username,$app_dbase_password);
  if (!$con)
  {
    die('Could not connect: ' . mysql_error() . '<br><br>');
  }
  
  if (mysql_query("CREATE DATABASE " . $app_database_name,$con))
  {
    echo "Database created<br><br>";
    
    global $reconnect_to_bat;
    
    $reconnect_to_bat = 1;
  }
  else
  {
    echo "Error creating database: " . mysql_error() . "<br><br>";
  }

  mysql_close($con);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function batch_query($sql_batch)
{
	global $conn;
  
  $sql_batch_array = $pieces = explode(";", $sql_batch);
	
	$x = count($sql_batch_array)-1;
	
  for($i=0; $i < $x;$i++)
  {
    $sql = $sql_batch_array[$i];

		$temp_query = mysql_query($sql, $conn);
		
    if(mysql_error())echo "<font color='red'><b>batch query error : <hr>" . mysql_error() . "<hr></b></font>";
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>