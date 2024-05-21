<?php
// Database configuration
$host = "phpmyadmin.alwaysdata.com";
$dbuser = "root";
$dbpass = "Azerty";
$dbname = "vroomcar";
// Create database connection
$link = mysqli_connect($host, $dbuser, $dbpass, $dbname);
// Check connection
if(mysqli_connect_error())
{
echo "Connection establishing failed! <br >";
}

?>