<?
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function debug_info()
{
	if(isset($_SESSION['show_debug']) && $_SESSION['show_debug'] == "yes")
	{
		global $bat_ts_page,$page_render_time;

		$timeend_bat_page = microtime();
	  $page_render_time = number_format(((substr($timeend_bat_page,0,9)) + (substr($timeend_bat_page,-10)) - (substr($bat_ts_page,0,9)) - (substr($bat_ts_page,-10))),3);

    global $HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_SESSION_VARS,$HTTP_COOKIE_VARS,$HTTP_SERVER_VARS,
    $HTTP_ENV_VARS,$query_debug_info,$app_admin_access;

    ?>
    <table style="table-layout:fixed" bgcolor="#F1F1F1">
    	<tr>
    		<td><?
        echo "<hr><b>page rendering took $page_render_time s</b>";

    		echo "<hr><b>Debug info</b>";

    		echo "<hr>session id = " . session_id();

    		echo "<hr>peak memory used = " . memory_get_peak_usage() / 1000 . " Kbytes";

        if(isset($query_debug_info))
        {
          echo $query_debug_info;
        }

        $variableSets = array(
        "<b>Post:</b>" => $HTTP_POST_VARS,
        "<b>Get:</b>" => $HTTP_GET_VARS,
        "<b>Session:</b>" => $HTTP_SESSION_VARS,
        "<b>Cookies:</b>" => $HTTP_COOKIE_VARS,
        "<b>Server:</b>" => $HTTP_SERVER_VARS,
        "<b>Environment:</b>" => $HTTP_ENV_VARS
        );

        function printElementHtml( $value, $key )
    		{
          echo $key . " => ";
          print_r( $value );
          echo "<br>";
        }

        foreach ( $variableSets as $setName => $variableSet )
        {
          if ( isset( $variableSet ) )
          {
            echo "<hr size='1'>";
            echo "$setName<br>";
            @array_walk( $variableSet, 'printElementHtml' );
          }
        }
    	?>
    		</td>
    	</tr>
    </table><?
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function add_to_debug($string)
{
	global $app_query_debug_info,$query_debug_info;
  
  if($app_query_debug_info == "yes")
  {
    $query_debug_info = $query_debug_info . "<br><br><font style='background-color:#CECEFF;color:black'>" . $string . "</font>";
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function bat_timer_start($timer_name)
{
  global ${"bat_timer_start_" . $timer_name};
  
  ${"bat_timer_start_" . $timer_name} = microtime();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function bat_timer_stop($timer_name)
{
  global ${"bat_timer_start_" . $timer_name};
  
  if(isset(${"bat_timer_start_" . $timer_name}))
  {
    ${"bat_timer_stop_" . $timer_name} = microtime();
    
    ${"bat_timer_diff_" . $timer_name} = number_format(((substr(${"bat_timer_stop_" . $timer_name},0,9)) + (substr(${"bat_timer_stop_" . $timer_name},-10)) - (substr(${"bat_timer_start_" . $timer_name},0,9)) - (substr(${"bat_timer_start_" . $timer_name},-10))),3);
    
    add_to_debug("BAT TIMER : <b>" . $timer_name . " = " . ${"bat_timer_diff_" . $timer_name} . "</b>");
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>