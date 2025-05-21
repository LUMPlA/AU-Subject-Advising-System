<?php
//define database connection
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'alfa');
define('DB_PASSWORD', 'tabal');
define('DB_NAME', 'itc1272a');

//attempt to connect
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check if connection is unsuccessful
if($link === false)
{
	die("ERROR: Could not conect," . mysqli_connect_error());
}
//set time zone
date_default_timezone_set('Asia/Manila')
?>

