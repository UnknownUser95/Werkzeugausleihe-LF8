<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Mitarbeiter erstellen</title>
<link rel="stylesheet" type="text/css" href="./../common/create.css">
</head>
<body>
	<?php require_once './../header.html'; ?>
	<main>
		<?php
		require_once './../common/functions.php';
		require_once './../db/workers.php';
		setIfNotDefined(WORKER_ARGS);
		?>
		<form method="post">
			<div class="editor">
				<div>
					<span>Vorname:</span>
					<input required type="text" name="vorname" value="<?php echo $_POST['vorname']; ?>" />
				</div>
				<div>
					<span>Nachname:</span>
					<input required type="text" name="nachname" value="<?php echo $_POST['nachname']; ?>" />
				</div>
				<div>
					<span>Geburtsdatum:</span>
					<input required type="date" name="geburtsdatum" value="<?php echo $_POST['geburtsdatum']; ?>" />
				</div>
				<button id="save-button" type="submit" name="save" value="save">save</button>
			</div>
		</form>
		<?php
		if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])) {
			$msg = verify(WORKER_ARGS);
			$err = $msg !== "";
			
			if($msg === "") {
				if(createWorker($_POST['vorname'], $_POST['nachname'], $_POST['geburtsdatum'])) {
					$msg = 'Mitarbeiter erstellt';
				} else {
					$msg = "Ein Fehler is aufgetreten";
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