<?php
session_start();

$server = "localhost";
$user = "root";
$password = "root";
$db = "werkzeugausleihe";

global $conn;
$conn = new mysqli($server, $user, $password, $db);

if($conn->connect_error) {
	exit("db connection failed: " + $conn->connect_error);
}

if(!$conn->set_charset("utf8mb4")) {
	exit("could not change charset");
}

define("CON", "db_connection");
$_SESSION[CON] = $conn;

define("DATE_FORMAT", 'Y-m-d');
function strToDate($str) {
	return date(DATE_FORMAT, strtotime($str));
}
