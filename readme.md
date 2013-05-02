Base Application Template (B.A.T) V1.01 by Riz Khan
===================================================
 The Base Application Template has been created to aid PHP developers by providing :

• Query debugging
• Query execution times
• Page load times
• Peak memory usage per page
• Debug data for post, get, cookie, server, environment and session variables
• Ability to include custom debug data
• Faster development time using the provided query function which requires less coding

Installation
============

Extract the files to your web root directory. Edit the file “ini_settings.php”, this is the only file you have to edit to get the demo up and running.

The variables defined here are :

• $app_database_server = your mysql server location and port 
• $app_database_name = the database name you wish to use for this demo 
• $app_dbase_username = mysql username for accessing database 
• $app_dbase_password = mysql password for accessing database 
• $app_table_write_locking = values are “yes” or “no”, when set to yes all write queries use mysql table locking automatically! 
• $app_pre_query_debug_echo = default is “no”, only enable it to yes if you wish to see all your sql statements echoed on the screen as its being executed! 
• $app_query_debug_info = default value is “yes”, this enables or disables the capturing (not display) of debug information.

Once you have edited the settings file, you may restore the database for this demo by using the following url :
http://yourwebserver/bat/?ct=restore_database  After the database has been restored run the application using the url below :
http://yourwebserver/bat/?bat_debug=yes

By using the url parameter “bat_debug” you can enable or disable the visual output of debug information. You can further customize this trigger based on your own criteria by modifying the file “ini_debug.php”.

Queries and BAT
===============

The Base Application Template relies on executing queries differently, this is done by using the provided query function.  For example a normal query and screen output would look something like this :  $get_users_query = mysql_query(“select firstname,lastname from users”, $conn) or die(mysql_error());  while($get_users=mysql_fetch_array($get_users_query)) {     echo $get_users['firstname'] . ' ' . $get_users['lastname'] . "<br>"; }

The equivalent in BAT looks like :  query("get_users","select firstname, lastname from users");  while($get_users=mysql_fetch_array($get_users_query)) {     echo $get_users['firstname'] . ' ' . $get_users['lastname'] . "<br>"; }  The query function also automatically returns the record count, for the example above the variable returned would be $get_users_recordcount.

To execute a write query use the query_write function. The query_write function takes three parameters, a query name, sql query and the table name or custom locking parameters.  Here are two examples :  query_write("insert_user_1","insert into users (firstname,lastname) values ('Zaid','Khan')","users");
query_write("insert_user_2","insert into users (firstname,lastname) values ('Saira','Khan')","users WRITE");  They both essentially do the same thing, however with the second query you can extend your locking parameters to span multiple tables, should your query require it. E.g “users WRITE, jobs WRITE”.

Adding your own debug
=====================

You can easily utilise the add_to_debug function to add any custom debug information that you require. E.g :  add_to_debug("MyVar = " . $MyVar);

Measuring code execution time
=============================
If you wish to measure how long a segment of code takes to run you can use the provided timer functions, e.g :  bat_timer_start("timer1");  {any php code or content here will be timed}  bat_timer_stop("timer1");  The results of “timer1” will be displayed in debug.

BAT Files and Structure
=======================

The Base Application Template comes with a basic framework from which you can rapidly begin to build your own applications. The framework essentially calls one header, a defined content page using the url variable “CT” and one footer.  For example the url http://yourwebserver/bat/?ct=home displays the contents of home.php.  The next page outlines the files of this structure and briefly touches on its function. For a better understanding I do recommend you have a look inside these files.

License
=======

The Base Application Template is distributed under the GPL License. You are free to use it in commercial or non-commercial projects and to modify it to suit your needs. I do request however that you display one of the BAT logos somewhere in your project or site. Please use the provided link and image title attribute below. These files are included with the demo under the “images” directory.         
Link to project on github : https://github.com/rizkhan7/bat
Title attribute for image : “Powered by Base Application Template”

File notes
==========

• index.php

The index page which calls all required includes and page display handler.

Files called are :
ini_includes.php
display_output.php

• ini_includes.php

Starts the debug timer and calls all required includes.

Files called are :
ini_session.php
functions_debug.php
ini_settings.php
functions.php
ini_db_connect.php
functions_database.php
ini_debug.php

• display_output.php

Is responsible for displaying the page.

Files called are :
header.php
footer.php

It also renders any file defined in the url variable “CT” in between the header and footer. If “CT” short for content is not defined the default include becomes “home.php”.

• ini_session.php

Initialises the application session.

• functions_debug.php

All BAT debug functions are located here.

• ini_settings.php

This is the settings file which you customise to reflect your host environment.

• functions.php

You may add your custom functions here.

• ini_db_connect.php

Establishes a database connection to your server using the settings from ini_settings.php

• functions_database.php

All query functions reside in this file.

• ini_debug.php

This file is responsible for turning debug on or off. Feel free to modify this file to suit who sees debug information.

• header.php

This is the html header file. The css file is also defined here.

• footer.php

The html footer file, the display of debug is also called from this file.

• home.php

The default included file when the url variable CT is not defined. This is the page where the demo queries are executed.

• restore_database.php

Call this page to restore the example database.

• bat_demo_database.sql

SQL dump of the BAT demo database, you may use it for a manual restore if you prefer.

Updates
=======
 v1.01 (5 May 2013)
* removed a bug in the code where debug would only display on a localhost server.