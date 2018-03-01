<?php
$hst = 'localhost';
$usr = 'root';
$psw = '';
$dbn = 'db_inventory';

$conn = mysql_connect($hst, $usr, $psw) or die("Cannot establish connection!");
mysql_select_db($dbn, $conn) or die("Database not found!");

session_start();
?>