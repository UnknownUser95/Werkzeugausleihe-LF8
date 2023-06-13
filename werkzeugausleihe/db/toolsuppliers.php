<?php
session_start();
require_once __DIR__.'/connection.php';

define("TOOL_SUPPLIER_ARGS", ["lieferantennr", "anschaffungsdatum", "anschaffungspreis", "werkzeugnr"]);
define("FULL_TOOL_SUPPLIER_ARGS", ["exemplarnr", "lieferantennr", "anschaffungsdatum", "anschaffungspreis", "werkzeugnr"]);

function deleteToolSupplier(int $id): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("DELETE FROM werkzeuglieferant WHERE exemplarnr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getAllToolSuppliers(): array {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM werkzeuglieferant");
	
	$workers = [];
	while($row = $result->fetch_assoc()) {
		$workers[] = $row;
	}
	
	return $workers;
}

function getToolSupplierByID(int $id): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM werkzeuglieferant WHERE exemplarnr = {$id}")->fetch_assoc();
}

function editToolSupplier(int $id, int $lieferantennr, string $anschaffungsDatum, int $anschaffungsPreis, int $werkzeugnr): bool {
	$conn = $_SESSION[CON];
	$anschaffungsDatum = $conn->real_escape_string($anschaffungsDatum);
	try {
		$conn->query("UPDATE werkzeuglieferant SET lieferantennr = '{$lieferantennr}', anschaffungsdatum = '{$anschaffungsDatum}', anschaffungspreis = '{$anschaffungsPreis}', werkzeugnr = '{$werkzeugnr}' WHERE exemplarnr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function createToolSupplier(int $lieferantennr, string $anschaffungsDatum, float $anschaffungsPreis, int $werkzeugnr): bool {
	$conn = $_SESSION[CON];
	$anschaffungsDatum = $conn->real_escape_string($anschaffungsDatum);
	try {
		$conn->query("INSERT INTO werkzeuglieferant (lieferantennr, anschaffungsdatum, anschaffungspreis, werkzeugnr) VALUES ({$lieferantennr}, '{$anschaffungsDatum}', {$anschaffungsPreis}, {$werkzeugnr})");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function formatToolSupplier(int $id): string {
	$supplier = getToolSupplierByID($id);
	return formatToolSupplierResult($supplier);
}

function formatToolSupplierResult($supplier): string {
	return getToolNameFromID($supplier['werkzeugnr'])." ({$supplier['anschaffungsdatum']}@{$supplier['anschaffungspreis']})";
}

function getSupplierNameFromID(int $id): string {
	require_once __DIR__.'/suppliers.php';
	return getSupplierByID($id)['firma'];
}

function getToolNameFromID(int $id): string {
	require_once __DIR__.'/tools.php';
	return getToolByID($id)['bezeichnung'];
}

function toolsupplierCanBeDeleted(int $id): bool {
	$conn = $_SESSION[CON];
	
	$result = $conn->query("SELECT * FROM werkzeugausleihe WHERE exemplarnr = {$id}");
	
	return $result->num_rows === 0;
}
