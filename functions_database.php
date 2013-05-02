<?
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function query($queryname, $sql)
{
	/*===================================================================
	Author: Riz Khan (rizwaankhan@hotmail.com)

	This function returns a query from mysql.

	$queryname = the name of the query.
			  $sql = query in sql format.

	Process query as normal after query function

	e.g if $query_name = "get_riz"

	query("get_riz","select id from table");

	while($get_riz=mysql_fetch_array($get_riz_query))
	{
		echo $get_riz['id'];
	}

	this function automatically returns a recordcount e.g

	$get_riz_recordcount;

	NOTICE: You may use this code for any purpose, commercial or
	private, without any further permission from the author as long
	as this message remains intact.
	===================================================================*/

	global $app_pre_query_debug_echo,$app_query_debug_info,$query_debug_info,$app_mysql_error_logging;

  global $conn,${$queryname . "_query"},${$queryname . "_recordcount"};

  $ratemypet_query = microtime();

	if($app_pre_query_debug_echo == "yes") echo "<hr><font style='background-color:aqua'>" . $sql . "</font>";

  ${$queryname . "_query"} = mysql_query($sql, $conn);

  $timeend_query = microtime();
  $diff_query = number_format(((substr($timeend_query,0,9)) + (substr($timeend_query,-10)) - (substr($ratemypet_query,0,9)) - (substr($ratemypet_query,-10))),3);

  if(mysql_error())
  {
    ${$queryname . "_recordcount"} = 0;
  }
  else
  {
    ${$queryname . "_recordcount"} = mysql_num_rows(${$queryname . "_query"});
  }

  capture_debug($queryname,$sql,$diff_query);
  
  if(mysql_error())
  {
    mysql_error_exit_handler($sql);
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function query_write($queryname, $sql, $table_or_custom_lock)
{
  /*===================================================================
	Author: Riz Khan (rizwaankhan@hotmail.com)

	This function is used for write queries

	$queryname = the name of the query.
			  $sql = query in sql format.
			$table_or_custom_lock = name of table that the record is being updated or inserted to, or you can define custom locking, e.g "users WRITE, table2 WRITE"

	If locking is enabled then the table is automatically locked for any writes.

	NOTICE: You may use this code for any purpose, commercial or
	private, without any further permission from the author as long
	as this message remains intact.
	===================================================================*/

	global $app_pre_query_debug_echo,$app_table_write_locking,$mysql_last_insert_id,$app_mysql_error_logging;

  global $conn,${$queryname . "_query"},${$queryname . "_recordcount"};

  if($app_table_write_locking == "yes")
  {
    if($table_or_custom_lock != "")
		{
		  if(strpos($table_or_custom_lock," "))
      {
        $query = "LOCK TABLES " . $table_or_custom_lock;
      }
      else
      {
        $query = "LOCK TABLES " . $table_or_custom_lock . " WRITE";
      }
			mysql_query($query,$conn) or mysql_error_exit_handler();
		}
  }

  $ratemypet_query = microtime();

	if($app_pre_query_debug_echo == "yes") echo "<hr><font style='background-color:aqua'>" . $sql . "</font>";

  ${$queryname . "_query"} = mysql_query($sql, $conn);

	$timeend_query = microtime();
  $diff_query = number_format(((substr($timeend_query,0,9)) + (substr($timeend_query,-10)) - (substr($ratemypet_query,0,9)) - (substr($ratemypet_query,-10))),3);

	${$queryname . "_recordcount"} = @mysql_affected_rows();

	capture_debug($queryname,$sql,$diff_query);
  
  if(mysql_error())
  {
    mysql_error_exit_handler($sql);
  }

  $mysql_last_insert_id = mysql_insert_id();

	if($app_table_write_locking == "yes")
  {
    if($table_or_custom_lock != "")
		{
		  $query = "UNLOCK TABLES";
			mysql_query($query,$conn) or mysql_error_exit_handler();
		}
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function capture_debug($queryname,$sql,$secs)
{
  global $app_query_debug_info;
  
  if($app_query_debug_info == "yes")
  {
    global $query_debug_info,${$queryname . "_recordcount"};

    if($secs != "")
    {
      $sec_string = "query took " . $secs . " s";
    }
    else
    {
      $sec_string = "";
    }
    
    if(isset(${$queryname . "_recordcount"}))
		{
			$rowcount = " (" . ${$queryname . "_recordcount"} . " rows, ";
		}
		else
		{
			$rowcount = "";
		}

		if($sec_string != "")
		{
			//color code secs
			if($secs < 1)
			{
				$sec_string = "<font color='green'>" . $sec_string . "</font>";
			}
			elseif($secs < 2)
			{
				$sec_string = "<font color='brown' style='background-color:white'>" . $sec_string . "</font>";
			}
			else
			{
				$sec_string = "<font color='red' style='background-color:white'>" . $sec_string . "</font>";
			}

			if($rowcount == "")
			{
				$sec_string = " (" . $sec_string . ")";
			}
			else
			{
				$sec_string = "" . $sec_string . ")";
			}
		}

		if(!isset($query_debug_info))
		{
		  $query_debug_info = "<hr><b>Queries:</b><br>";
		  $query_debug_info = $query_debug_info . "<b>" . $queryname . $rowcount . $sec_string . "</b><br>" . $sql;
		}
		else
		{
	    $query_debug_info = $query_debug_info . "<br><br>" . "<b>" . $queryname . $rowcount . $sec_string . "</b><br>" . $sql;
		}
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mysql_error_exit_handler($sql)
{
  add_to_debug ("<font color='red' style='background-color:white'><b>A fatal MySQL error occured</b>.<br>Query: " . $sql . "<br>Error: (" . mysql_errno() . ") " . mysql_error() ."</font>");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>