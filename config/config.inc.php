<?php
/******************************************************************************
*		File : config.inc.php                                                 *
*       Created By : ValueOnWeb Panel User                                    *
*       Organization  : ValueOnWeb                                            *
*       Date Created : Tuesday 27 March 2007, 1:05 PM                         *
*       Date Modified : Tuesday 27 March 2007, 1:05 PM                        *
*       File Comment : This file contain functions which will use in coding.  *
*                                                                             *
*******************************************************************************/

if(stripos($_SERVER['HTTP_HOST'], "localhost") !== -1 || $_SERVER['HTTP_HOST']=="umit") {
	// Config setting for localhost.
	define('DBSERVER',"localhost:8889");
	define('DBNAME',"essayjudge");
	define('DBUSER',"essayjudge");
	define('DBPASS',"essayjudge");
	define('SITE_URL',"http://localhost:8888/essayjudge");
	define('SITE_FS_PATH',"/Applications/MAMP/htdocs/essayjudge");
	define('SITE_PATH',"http://localhost:8888/essayjudge");
} else {
	// Config setting for live server.
	define('DBSERVER',"YOUR_DB_SERVER");
	define('DBNAME',"YOUR_DB_NAME");
	define('DBUSER',"YOUR_DB_USER");
	define('DBPASS',"YOUR_DB_PASS");
	define('SITE_URL',"http://www.essayjudge.com");
	define('SITE_FS_PATH',"/home/document/public_html");
	define('SITE_PATH',"http://www.essayjudge.com");
}

// Database Connection Establishment String
mysql_connect(DBSERVER,DBUSER,DBPASS);

// Database Selection String
mysql_select_db(DBNAME);

// Some common settings

define('PAGE_SIZE',"15");
define('SITE_TITLE',"Document");
define('SITE_ADMIN_TITLE',"Document - Admin Area");

?>
