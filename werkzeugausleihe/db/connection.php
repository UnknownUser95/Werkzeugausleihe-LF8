<?php
// namespace werkzeugausleihe\db;
// use mysqli;
$server = "localhost";
$user = "root";
$password = "root";
$db = "werkzeugausleihe";

global $conn;
$conn = new mysqli($server, $user, $password, $db);

if($conn->connect_error) {
	exit("db connection failed: " + $conn->connect_error);
}

if(!$conn->set_charset("utf8")) {
	exit("could not change charset");
}

function query($q) {
	global $conn;
	return $conn->query($q);
}
