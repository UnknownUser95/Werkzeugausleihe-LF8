<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Werkzeug erstellen</title>
<link rel="stylesheet" type="text/css" href="./../common/create.css">
</head>
<body>
	<?php require_once './../header.html'; ?>
	<main>
		<?php
		require_once './../common/functions.php';
		require_once './../db/tools.php';
		setIfNotDefined(TOOL_ARGS);
		?>
		<form method="post">
			<div class="editor">
				<div>
					<span>Bezeichnung:</span>
					<input type="text" name="bezeichnung" value="<?php echo $_POST['bezeichnung']; ?>" />
				</div>
				<div>
					<span>Beschreibung:</span>
					<input type="text" name="beschreibung" value="<?php echo $_POST['beschreibung']; ?>" />
				</div>
				<button id="save-button" type="submit" name="save" value="save">save</button>
			</div>
		</form>
		<?php
		if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])) {
			$msg = verify(TOOL_ARGS);
			$err = $msg !== "";
			
			if($msg === "") {
				if(createTool($_POST['bezeichnung'], $_POST['beschreibung'])) {
					$msg = 'Werkzeug erstellt';
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