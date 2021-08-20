<?php
/*File contains database configuration assuming
mysql user "root" and password ""
*/

define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','login');

//Trying to connect to database
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

//Checking connection
if ($conn == false)
{
    dir('Error 404: Cannot connect');
}


?>