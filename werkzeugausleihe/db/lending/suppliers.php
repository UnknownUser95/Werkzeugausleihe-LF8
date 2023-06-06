<?php
session_start();
require_once './../../db/connection.php';

define("LENDER_SUPPLIER_ARGS", ["lieferantenrn", "anschaffungsdatum", "anschaffungspreis", "werkzeugnummer"]);
define("FULL_LENDER_SUPPLIER_ARGS", ["exemplarnr", "lieferantenrn", "anschaffungsdatum", "anschaffungspreis", "werkzeugnummer"]);

function deleteLenderSupplier($id): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("DELETE FROM werkzeuglieferant where exemplarnr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getAllLenderSuppliers(): array {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM werkzeuglieferant");
	
	$workers = [];
	while($row = $result->fetch_assoc()) {
		$workers[] = $row;
	}
	
	return $workers;
}

function getLenderSupplierByID(int $id): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM werkzeuglieferant WHERE exemplarnr = {$id}")->fetch_assoc();
}

function editLenderSupplier(int $id, int $lieferantennr, string $anschaffungsDatum, float $anschaffungsPreis, int $werkzeugnr): bool {
	$conn = $_SESSION[CON];
	$anschaffungsDatum = $conn->real_escape_string($anschaffungsDatum);
	try {
		$conn->query("UPDATE werkzeuglieferant SET lieferantennr = '{$lieferantennr}', anschaffungsdatum = '{$anschaffungsDatum}', anschaffungspreis = '{$anschaffungsPreis}', werkzeugnr = '{$werkzeugnr}' WHERE exemplarnr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function createLenderSupplier(int $lieferantennr, string $anschaffungsDatum, float $anschaffungsPreis, int $werkzeugnr): bool {
	$conn = $_SESSION[CON];
	$anschaffungsDatum = $conn->real_escape_string($anschaffungsDatum);
	try {
		$conn->query("INSERT INTO werkzeuglieferant (lieferantennr, anschaffungsdatum, anschaffungspreis, werkzeugnr') VALUES ({$lieferantennr}, {$anschaffungsDatum}, {$anschaffungsPreis}, {$werkzeugnr})");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getSupplierNameFromID(int $id) {
	require_once './../../db/suppliers.php';
	return getSupplierByID($id)['firma'];
}

function getToolNameFromID(int $id) {
	require_once './../../db/tools.php';
	return getToolByID($id)['bezeichnung'];
}
