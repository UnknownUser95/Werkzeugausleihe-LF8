<?php
session_start();
require_once __DIR__.'/connection.php';

define("TOOL_LENDING_ARGS", ["exemplarnr", "mitarbeiternr", "ausleihdatum"]);
define("SHOULD_BE_SET_TOOL_LENDING_ARGS", ["exemplarnr", "mitarbeiternr", "ausleihdatum", "rueckgabedatum"]);
define("FULL_TOOL_LENDING_ARGS", ["exemplarnr", "mitarbeiternr", "ausleihdatum", "rueckgabedatum", "zurueckgegebenam"]);
define("TOOL_LENDING_NULLABLE_ARGS", ["rueckgabedatum", "zurueckgegebenam"]);

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
	
	$lending = [];
	while($row = $result->fetch_assoc()) {
		$lending[] = $row;
	}
	
	return $lending;
}

function getToolLendingByID(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM werkzeugausleihe WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'")->fetch_assoc();
}

function createToolLending(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, string $rueckgabedatum): bool {
	$conn = $_SESSION[CON];
	
	$ausleihdatum = _nullOrDate($ausleihdatum);
	$rueckgabedatum = _nullOrDate($rueckgabedatum);
	
	try {
		$conn->query("INSERT INTO werkzeugausleihe (exemplarnr, mitarbeiternr, ausleihdatum, rueckgabedatum) VALUES ({$exemplarnr}, {$mitarbeiternr}, {$ausleihdatum}, {$rueckgabedatum})");
		return true;
	} catch (mysqli_sql_exception $exc) {
		echo $exc;
		return false;
	}
}

function fullEdit(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, $rueckgabedatum, $zurueckgegebenam): bool {
	$conn = $_SESSION[CON];
	
	$rueckgabedatum = _nullOrDate($rueckgabedatum);
	$zurueckgegebenam = _nullOrDate($zurueckgegebenam);
	
	try {
		$conn->query("UPDATE werkzeugausleihe SET rueckgabedatum = {$rueckgabedatum}, zurueckgegebenam = {$zurueckgegebenam} WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'");
		return true;
	} catch (mysqli_sql_exception $exc) {
		echo $exc;
		return false;
	}
}

function setReturnedAtDate(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, string $rueckgabedatum): bool {
	$conn = $_SESSION[CON];
	
	$rueckgabedatum = _nullOrDate($rueckgabedatum);
	
	try {
		$conn->query("UPDATE werkzeugausleihe SET rueckgabedatum = {$rueckgabedatum} WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'");
		return true;
	} catch (mysqli_sql_exception $exc) {
		echo $exc;
		return false;
	}
}

function setReturnByDate(int $exemplarnr, int $mitarbeiternr, string $ausleihdatum, string $zurueckgegebenam): bool {
	$conn = $_SESSION[CON];
	
	$zurueckgegebenam = _nullOrDate($zurueckgegebenam);
	
	try {
		$conn->query("UPDATE werkzeugausleihe SET zurueckgegebenam = {$zurueckgegebenam} WHERE exemplarnr = {$exemplarnr} AND mitarbeiternr = {$mitarbeiternr} AND ausleihdatum = '{$ausleihdatum}'");
		return true;
	} catch (mysqli_sql_exception $exc) {
		echo $exc;
		return false;
	}
}

function getUnavailableTools(): array {
	$conn = $_SESSION[CON];
	
	$result = $conn->query("SELECT exemplarnr FROM werkzeugausleihe WHERE zurueckgegebenam IS NULL");
	
	$tools = [];
	while($row = $result->fetch_assoc()) {
		$tools[] = $row['exemplarnr'];
	}
	
	return $tools;
}

function _nullOrDate($date) {
	return ($date === null || $date === "") ? "NULL" : "'{$date}'";
}

function printNullableDate($date, string $fallback = "n.A.") {
	return ($date !== null) ? $date : $fallback;
}
