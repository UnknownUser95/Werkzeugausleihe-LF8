<?php
session_start();
require_once 'connection.php';

function deleteWorker($id) {
	$conn = $_SESSION[CON];
	return $conn->query("DELETE FROM mitarbeiter where mitarbeiternr = ${id}");
}

function getAllWorkers() {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM mitarbeiter");
	
	$workers = [];
	while($row = $result->fetch_assoc()) {
		$workers[] = $row;
	}
	
	return $workers;
}

function getWorkerByID($id) {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM mitarbeiter WHERE mitarbeiternr = ${id}")->fetch_assoc();
}

function editWorker($id, $vorname, $nachname, $geburtsdatum) {
	$conn = $_SESSION[CON];
	$vorname = $conn->real_escape_string($vorname);
	$nachname = $conn->real_escape_string($nachname);
	$geburtsdatum = $conn->real_escape_string($geburtsdatum);
	return $conn->query("UPDATE mitarbeiter SET vorname = '${vorname}', nachname = '${nachname}', geburtsdatum = '${geburtsdatum}' WHERE mitarbeiternr = ${id}");
}

function createWorker($vorname, $nachname, $geburtsdatum) {
	$conn = $_SESSION[CON];
	$vorname = $conn->real_escape_string($vorname);
	$nachname = $conn->real_escape_string($nachname);
	$geburtsdatum = $conn->real_escape_string($geburtsdatum);
	return $conn->query("INSERT INTO mitarbeiter (vorname, nachname, geburtsdatum) VALUES ('{$vorname}', '{$nachname}', '{$geburtsdatum}')");
}
