<?php
namespace werkzeugausleihe;

use mysqli;

function getConnection(): mysqli {
    $server = "localhost";
    $user = "root";
    $password = "root";
    $db = "werkzeugausleihe";
    
    $conn = new mysqli($server, $user, $password, $db);
    
    if($conn->connect_error) {
    	exit("db connection failed: " + $conn->connect_error);
    }
    
    if(!$conn->set_charset("utf8")) {
    	exit("could not change charset");
    }
    
    return $conn;
}
