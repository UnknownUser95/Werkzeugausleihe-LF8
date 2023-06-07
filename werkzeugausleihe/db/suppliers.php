<?php
session_start();
require_once __DIR__.'/connection.php';

define("SUPPLIER_ARGS", ["firma", "ansprechpartnerName", "ansprechpartnerEmail", "ansprechpartnerTelefon"]);
define("FULL_SUPPLIER_ARGS", ["lieferantennr", "firma", "ansprechpartnerName", "ansprechpartnerEmail", "ansprechpartnerTelefon"]);

function deleteSupplier(int $id): bool {
	$conn = $_SESSION[CON];
	try {
		$conn->query("DELETE FROM lieferant WHERE lieferantennr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function getAllSuppliers(): array {
	$conn = $_SESSION[CON];
	$result = $conn->query("SELECT * FROM lieferant");
	
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
function getSupplierByID(int $id): array {
	$conn = $_SESSION[CON];
	return $conn->query("SELECT * FROM lieferant WHERE lieferantennr = {$id}")->fetch_assoc();
}

function editSupplier(int $id, string $firma, string $ansprechpartnerName, string $ansprechpartnerEmail, string $ansprechpartnerTelefon): bool {
	$conn = $_SESSION[CON];
	$firma = $conn->real_escape_string($firma);
	$ansprechpartnerName = $conn->real_escape_string($ansprechpartnerName);
	$ansprechpartnerEmail = $conn->real_escape_string($ansprechpartnerEmail);
	$ansprechpartnerTelefon = $conn->real_escape_string($ansprechpartnerTelefon);
	try {
		$conn->query("UPDATE lieferant SET firma = '{$firma}', ansprechpartnerName = '{$ansprechpartnerName}', ansprechpartnerEmail = '{$ansprechpartnerEmail}', ansprechpartnerTelefon = '{$ansprechpartnerTelefon}' WHERE lieferantennr = {$id}");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}

function createSupplier(string $firma, string $ansprechpartnerName, string $ansprechpartnerEmail, string $ansprechpartnerTelefon): bool {
	$conn = $_SESSION[CON];
	$firma = $conn->real_escape_string($firma);
	$ansprechpartnerName = $conn->real_escape_string($ansprechpartnerName);
	$ansprechpartnerEmail = $conn->real_escape_string($ansprechpartnerEmail);
	$ansprechpartnerTelefon = $conn->real_escape_string($ansprechpartnerTelefon);
	try {
		$conn->query("INSERT INTO lieferant (firma, ansprechpartnerName, ansprechpartnerEmail, ansprechpartnerTelefon) VALUES ('{$firma}', '{$ansprechpartnerName}', '{$ansprechpartnerEmail}', '{$ansprechpartnerTelefon}')");
		return true;
	} catch (mysqli_sql_exception $exc) {
		return false;
	}
}
