<?php

function verify(array $postargs, array $exceptions = []): string {
	$msg = '';
	$invalidKeys = array();
	
	function checkIfEmpty($key, $arr) {
		if(!isset($_POST[$key])) {
			$arr[] = $key;
		}
		return $arr;
	}
	
	foreach($postargs as $arg) {
		if(!in_array($arg, $exceptions)) {
			$invalidKeys = checkIfEmpty($arg, $invalidKeys);
		}
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

// function toPostArgs(array $arr) {
// 	foreach($arr as $key => $val) {
// 		$_POST[$key] = $val;
// 	}
// }

// function setPostVars(array $postKeys, $postVals): bool {
// 	if(sizeof($postKeys) !== sizeof($postVals)) {
// 		return false;
// 	}
	
// 	for($i = 0; $i < sizeof($postKeys); $i++) {
// 		$_POST[$postKeys[$i]] = $postVals[$i];
// 	}
// 	return true;
// }
