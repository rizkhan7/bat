<?
/* this is how to execute normal read queries */
query("get_users","select firstname, lastname
from
users");

while($get_users=mysql_fetch_array($get_users_query))
{
  echo $get_users['firstname'] . ' ' . $get_users['lastname'] . "<br>";
}

/* the recordcount of the query above is automatically returned in variable $get_users_recordcount */
echo "<hr> the query above returned " . $get_users_recordcount . " rows.";

/* this is how you can start a custom timer to measure the time it takes for code segments*/
bat_timer_start("timer1");

sleep(1);

/* the timer is instructed to stop below, the results are echoed in debug */
bat_timer_stop("timer1");

/* by using the add_to_debug function you can add any custom debug information that you require */
add_to_debug("You can add your own debug using the add_to_debug function!");

/* this is how write queries are performed, the example below locks a single table */
query_write("insert_user_1","insert into users (firstname,lastname) values ('Zaid','Khan')","users");

/* the write query below gives an example of custom locking parameters, you can reference multiple tables in the last parameter e.g "users WRITE, table2 WRITE" */
query_write("insert_user_2","insert into users (firstname,lastname) values ('Saira','Khan')","users WRITE");

?>
<hr><input type="button" value="Turn Debug On" onclick="window.location.href='?bat_debug=yes'">&nbsp;<input type="button" value="Turn Debug Off" onclick="window.location.href='?bat_debug=no'">