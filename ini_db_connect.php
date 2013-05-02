<?

$conn = mysql_connect($app_database_server, $app_dbase_username, $app_dbase_password);

mysql_select_db($app_database_name,$conn);

?>