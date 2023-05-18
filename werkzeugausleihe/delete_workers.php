<!DOCTYPE html>
<html lang="de">
<head>
<link rel="stylesheet" type="text/css" href="delete_workers.css">
<title>delete workers</title>
</head>
<body>
<?php
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['selected'])) {
//     require_once realpath($_SERVER['DOCUMENT_ROOT']).'/werkzeugausleihe/db/connection.php';
    require_once 'db/connection.php';
    
    $stmt = prepare("DELETE FROM mitarbeiter WHERE mitarbeiternr = ?");
    $stmt->bind_param("i", $id);
    
	$str = "";
	$first = true;
	foreach($_POST['selected'] as $id) {
	    $stmt->execute();
	    
		if(!$first) {
			$str .= ", ";
		}
		$str .= $id;
		$first = false;
	}
	echo "deleted ".$str;
} else {
	echo "nothing to delete";
}
?>
<div id="linkdiv">
<a id="link-back" href="workers.php">back</a>
</div>
</body>
</html>
