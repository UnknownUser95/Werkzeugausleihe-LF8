<?php
define("WORKER_ARGS", ["vorname", "nachname", "geburtsdatum"]);
define("FULL_WORKER_ARGS", ["mitarbeiternr", "vorname", "nachname", "geburtsdatum"]);

function verify(array $postargs): string {
	$msg = '';
	$invalidKeys = array();
	
	function checkIfEmpty($key, $arr) {
		if($_POST[$key] === '') {
			$arr[] = $key;
		}
		return $arr;
	}
	
	foreach($postargs as $arg) {
		$invalidKeys = checkIfEmpty($arg, $invalidKeys);
	}
	
	if(sizeof($invalidKeys) !== 0) {
		$first = true;
		foreach($invalidKeys as $str) {
			if(!$first) {
				$msg .= ', ';
			}
			
			$msg .= "'{$str}'";
			$first = false;
		}
		$msg .= ' darf nicht leer sein!';
	}
	return $msg;
}

function setIfNotDefined(array $args, $fallback = ''): void {
	foreach($args as $arg) {
		if(!isset($_POST[$arg])) {
			$_POST[$arg] = $fallback;
		}
	}
}
