<?php
session_start();
require_once __DIR__.'/connection.php';

define("TOOL_ARGS", ["bezeichnung", "beschreibung"]);
define("FULL_TOOL_ARGS", ["werkzeugnr", "bezeichnung", "beschreibung"]);

function deleteTool(int $id): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("DELETE FROM werkzeug WHERE werkzeugnr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getAllTools(): array {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM werkzeug");
	
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
function getToolByID(int $id): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM werkzeug WHERE werkzeugnr = {$id}")->fetch_assoc();
}

function editTool(int $id, string $bezeichnung, string $beschreibung): bool {
	$conn = $_SESSION[CON];
	$bezeichnung = $conn->real_escape_string($bezeichnung);
	$beschreibung = $conn->real_escape_string($beschreibung);
	try {
		$conn->query("UPDATE werkzeug SET bezeichnung = '{$bezeichnung}', beschreibung = '{$beschreibung}' WHERE werkzeugnr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function createTool(string $bezeichnung, string $beschreibung): bool {
	$conn = $_SESSION[CON];
	
	$bezeichnung = $conn->real_escape_string($bezeichnung);
	$beschreibung = $conn->real_escape_string($beschreibung);
	
	try {
		$conn->query("INSERT INTO werkzeug (bezeichnung, beschreibung) VALUES ('{$bezeichnung}', '{$beschreibung}')");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function toolCanBeDeleted(int $id): bool {
	$conn = $_SESSION[CON];
	
	$result = $conn->query("SELECT * FROM werkzeuglieferant WHERE lieferantennr = {$id}");
	
	return $result->num_rows === 0;
}
