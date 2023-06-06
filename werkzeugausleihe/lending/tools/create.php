<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Mitarbeiter erstellen</title>
<link rel="stylesheet" type="text/css" href="./../../common/create.css">
</head>
<body>
	<?php require_once './../../header.html'; ?>
	<main>
		<?php
		require_once './../../common/functions.php';
		require_once './../db/suppliers.php';
		setIfNotDefined(SUPPLIER_ARGS);
		?>
		<form method="post">
			<div class="editor">
				<div>
					<span>Firma:</span>
					<input type="text" name="firma" value="<?php echo $_POST['firma']; ?>" />
				</div>
				<div>
					<span>Name:</span>
					<input type="text" name="ansprechpartnerName" value="<?php echo $_POST['ansprechpartnerName']; ?>" />
				</div>
				<div>
					<span>Email:</span>
					<input type="text" name="ansprechpartnerEmail" value="<?php echo $_POST['ansprechpartnerEmail']; ?>" />
				</div>
				<div>
					<span>Telefon:</span>
					<input type="text" name="ansprechpartnerTelefon" value="<?php echo $_POST['ansprechpartnerTelefon']; ?>" />
				</div>
				<button id="save-button" type="submit" name="save" value="save">save</button>
			</div>
		</form>
		<?php
		if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])) {
			$msg = verify(SUPPLIER_ARGS);
			$err = $msg !== "";
			
			if($msg === "") {
				if(createSupplier($_POST['firma'], $_POST['ansprechpartnerName'], $_POST['ansprechpartnerEmail'], $_POST['ansprechpartnerTelefon'])) {
					$msg = 'Lieferant erstellt';
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