<?php
// Database configuration
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "vroomcar";
// Create database connection
$link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
// Check connection
if(mysqli_connect_error())
{
echo "Connection establishing failed! <br >";
}

?>