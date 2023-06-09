<?php
session_start();
require_once __DIR__.'/connection.php';

define("WORKER_ARGS", ["vorname", "nachname", "geburtsdatum"]);
define("FULL_WORKER_ARGS", ["mitarbeiternr", "vorname", "nachname", "geburtsdatum"]);

function deleteWorker(int $id): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("DELETE FROM mitarbeiter WHERE mitarbeiternr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getAllWorkers(): array {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM mitarbeiter");
	
	$workers = [];
	while($row = $result->fetch_assoc()) {
		$workers[] = $row;
	}
	
	return $workers;
}

/**
 * @param int $id the ID of th worker
 * @return array associative array
 */
function getWorkerByID(int $id): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM mitarbeiter WHERE mitarbeiternr = {$id}")->fetch_assoc();
}

function editWorker(int $id, string $vorname, string $nachname, string $geburtsdatum): bool {
	$conn = $_SESSION[CON];
	$vorname = $conn->real_escape_string($vorname);
	$nachname = $conn->real_escape_string($nachname);
	$geburtsdatum = $conn->real_escape_string($geburtsdatum);
	try {
		$conn->query("UPDATE mitarbeiter SET vorname = '{$vorname}', nachname = '{$nachname}', geburtsdatum = '{$geburtsdatum}' WHERE mitarbeiternr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function createWorker(string $vorname, string $nachname, string $geburtsdatum): bool {
	$conn = $_SESSION[CON];
	
	$vorname = $conn->real_escape_string($vorname);
	$nachname = $conn->real_escape_string($nachname);
	$geburtsdatum = $conn->real_escape_string($geburtsdatum);
	
	try {
		$conn->query("INSERT INTO mitarbeiter (vorname, nachname, geburtsdatum) VALUES ('{$vorname}', '{$nachname}', '{$geburtsdatum}')");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getWorkerNameFromID(int $id) {
	$worker = getWorkerByID($id);
	return getWorkerNameFromResult($worker);
}

function getWorkerNameFromResult($worker) {
	return "{$worker['nachname']}, {$worker['vorname']}";
}

function workerCanBeDeleted(int $id): bool {
	$conn = $_SESSION[CON];
	
	$result = $conn->query("SELECT * FROM werkzeugausleihe WHERE mitarbeiternr = {$id}");
	
	return $result->num_rows === 0;
}
