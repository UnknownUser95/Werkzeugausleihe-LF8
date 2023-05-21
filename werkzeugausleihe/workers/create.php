<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Mitarbeiter erstellen</title>
<link rel="stylesheet" type="text/css" href="create.css">
</head>
<body>
	<?php require_once './../header.html';?>
	<main>
		<?php

		function setIfNotDefined($key, $value = '') {
			if(!isset($_POST[$key])) {
				$_POST[$key] = $value;
			}
		}
		setIfNotDefined('vorname');
		setIfNotDefined('nachname');
		setIfNotDefined('geburtsdatum');
		?>
		<form method="post">
			<div class="editor">
				<div>
					<span>Vorname:</span>
					<input type="text" name="vorname" value="<?php echo $_POST['vorname']; ?>" />
				</div>
				<div>
					<span>Nachname:</span>
					<input type="text" name="nachname" value="<?php echo $_POST['nachname']; ?>" />
				</div>
				<div>
					<span>Geburtsdatum:</span>
					<input type="date" name="geburtsdatum" value="<?php echo $_POST['geburtsdatum']; ?>" />
				</div>
				<button id="save-button" type="submit" name="save" value="save">save</button>
			</div>
		</form>
		<?php
		if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])) {
			$err = false;
			$msg = '';
			$invalid_keys = array();

			function checkIfEmpty($key, $arr) {
				if($_POST[$key] === '') {
					$arr[] = $key;
				}
				return $arr;
			}
			$invalid_keys = checkIfEmpty('vorname', $invalid_keys);
			$invalid_keys = checkIfEmpty('nachname', $invalid_keys);
			$invalid_keys = checkIfEmpty('geburtsdatum', $invalid_keys);
			
			if(sizeof($invalid_keys) !== 0) {
				$err = true;
				$first = true;
				foreach($invalid_keys as $str) {
					if(!$first) {
						$msg .= ', ';
					}
					
					$msg .= "'{$str}'";
					$first = false;
				}
				$msg .= ' darf nicht leer sein!';
			}
			
			if(!$err) {
				require_once './../db/workers.php';
				try {
					createWorker($_POST['vorname'], $_POST['nachname'], $_POST['geburtsdatum']);
					$msg = 'Mitarbeiter erstellt';
				} catch(mysqli_sql_exception $exc) {
					$msg = $err;
					$err = true;
				}
			}
			?>
			<form method="post">
				<div class="result-message <?php echo ($err) ? "error-message" : "good-message"; ?>">
					<button type="submit">clear</button>
					<?php echo $msg; ?>
				</div>
			</form>
			<?php
		}
		?>
	</main>
</body>
</html>