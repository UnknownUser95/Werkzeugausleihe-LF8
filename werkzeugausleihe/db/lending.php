<?php
session_start();
require_once __DIR__.'/../connection.php';

define("TOOL_LENDING_ARGS", ["exemplarnr", "mitarbeiternr", "ausleihdatum"]);
define("FULL_TOOL_LENDING_ARGS", ["exemplarnr", "mitarbeiternr", "ausleihdatum", "rueckgabedatum", "zurueckgegebenam"]);

function deleteToolLending(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("DELETE FROM werkzeugausleihe WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getAllToolLendings(): array {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM werkzeugausleihe");
	
	$workers = [];
	while($row = $result->fetch_assoc()) {
		$workers[] = $row;
	}
	
	return $workers;
}

function getToolSupplierByID(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM werkzeugausleihe WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'")->fetch_assoc();
}

function createToolLending(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, string $rueckgabedatum): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("INSERT INTO werkzeugausleihe (exemplarnr, mitarbeiternr, ausleihdatum, rueckgabedatum) VALUES ({$exemplarnr}, {$mitarbeiternr}, '{$ausleihdatum}', '{$rueckgabedatum}')");
		return true;
	} catch (mysqli_sql_exception $exc) {
		echo $exc;
		return false;
	}
}

function setReturnByDateOnToolLending(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, string $rueckgabedatum): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("UPDATE werkzeugausleihe SET rueckgabedatum = '{$rueckgabedatum}' WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function setReturnedDateOnToolLending(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, string $rueckgegebenam): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("UPDATE werkzeugausleihe SET rueckgegebenam = '{$rueckgegebenam}' WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getWorkerNameFromID(int $id): string {
	require_once './../../db/workers.php';
	$worker = getWorkerByID($id);
	return $worker['nachname'].', '.$worker['vorname'];
}

function nullableDatePrint($date, string $default = 'n.A.'): string {
	if($date === null) {
		return $default;
	} else {
		return $date;
	}
}
