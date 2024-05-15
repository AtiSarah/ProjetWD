<?php
include("dbp.php"); 
session_start();
session_destroy();
header("Location: login.php");
?>