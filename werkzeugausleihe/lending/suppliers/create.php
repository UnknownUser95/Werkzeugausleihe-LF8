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
		require_once './../../db/lending/suppliers.php';
		require_once './../../db/suppliers.php';
		require_once './../../db/tools.php';
		setIfNotDefined(LENDER_SUPPLIER_ARGS);
		?>
		<form method="post">
			<div class="editor">
				<div>
					<span>Lieferant:</span>
					<select required name="lieferantennr">
					<?php foreach(getAllSuppliers() as $baseSupplier) {?>
						<option value="<?php echo $baseSupplier['lieferantennr'];?>" <?php if($baseSupplier['lieferantennr'] === $_POST['lieferantennr']) { echo 'selected="selected"'; } ?>><?php echo $baseSupplier['firma']; ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Werkzeug:</span>
					<select required name="werkzeugnr">
					<?php foreach(getAllTools() as $baseTool) {?>
						<option value="<?php echo $baseTool['werkzeugnr'];?>" <?php if($baseTool['werkzeugnr'] === $_POST['werkzeugnr']) { echo 'selected="selected"'; } ?>><?php echo $baseTool['bezeichnung']; ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Datum:</span>
					<input required type="date" name="anschaffungsdatum" value="<?php echo $_POST['anschaffungsdatum']; ?>" />
				</div>
				<div>
					<span>Preis:</span>
					<input required type="number" min="0" max="9999999999" name="anschaffungspreis" value="<?php echo $_POST['anschaffungspreis']; ?>" />
				</div>
				<button id="save-button" type="submit" name="save" value="save">save</button>
			</div>
		</form>
		<?php
		if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])) {
			$msg = verify(LENDER_SUPPLIER_ARGS);
			$err = $msg !== "";
			
			if($msg === "") {
				if(createLenderSupplier($_POST['lieferantennr'], $_POST['anschaffungsdatum'], $_POST['anschaffungspreis'], $_POST['werkzeugnr'])) {
					$msg = 'Werkzeuglieferant erstellt';
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