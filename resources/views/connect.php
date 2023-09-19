<?php

$databaseHost = 'localhost';
$databaseName = 'qa';
$databaseUsername = 'dev';
$databasePassword = 'p@ssW0rd_2011';

// Create connection
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

//*** Reject user not online
$intRejectTime = 5; // Minute
$sql = "UPDATE users SET Login = '0', LastUpdate = '0000-00-00 00:00:00'  WHERE DATE_ADD(LastUpdate, INTERVAL $intRejectTime MINUTE) <= NOW() ";
$query = mysqli_query($mysqli, $sql);
