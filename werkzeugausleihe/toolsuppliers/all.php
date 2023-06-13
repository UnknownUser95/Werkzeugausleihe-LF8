<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Werkzeuglieferanten</title>
<link rel="stylesheet" type="text/css" href="./../common/all.css">
</head>
<body>
<?php require_once './../header.html'; ?>
	<main>
	<?php
	require_once './../db/toolsuppliers.php';
	require_once './../db/suppliers.php';
	require_once './../db/tools.php';
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST['edit'])) {
			$supplier = getToolSupplierByID($_POST["edit"]);
			?>
		<form method="post">
			<div class="editor">
				<input type="hidden" name="exemplarnr" value="<?php echo $supplier['exemplarnr']; ?>" />
				<div>
					<span>Lieferant:</span>
					<select required name="lieferantennr">
					<?php foreach(getAllSuppliers() as $baseSupplier) {?>
						<option value="<?php echo $baseSupplier['lieferantennr'];?>" <?php if($baseSupplier['lieferantennr'] === $supplier['lieferantennr']) { echo 'selected="selected"'; } ?>><?php echo $baseSupplier['firma']; ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Werkzeug:</span>
					<select required name="werkzeugnr">
					<?php foreach(getAllTools() as $baseTool) {?>
						<option value="<?php echo $baseTool['werkzeugnr'];?>" <?php if($baseTool['werkzeugnr'] === $supplier['werkzeugnr']) { echo 'selected="selected"'; } ?>><?php echo $baseTool['bezeichnung']; ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Datum:</span>
					<input required type="date" name="anschaffungsdatum" value="<?php echo $supplier['anschaffungsdatum']; ?>" />
				</div>
				<div>
					<span>Preis:</span>
					<input required type="number" min="0" max="9999999999" name="anschaffungspreis" value="<?php echo $supplier['anschaffungspreis']; ?>" />
				</div>
				<div id="buttons">
					<button type="submit" name="edited" value="<?php echo $supplier['lieferantennr']; ?>">speichern</button>
					<button type="submit" name="cancel" value="<?php echo $supplier['lieferantennr']; ?>">abbrechen</button>
				</div>
			</div>
		</form>
		<?php
		}

		if(isset($_POST['edited'])) {
			require_once './../common/functions.php';
			$msg = verify(FULL_TOOL_SUPPLIER_ARGS);
			$err = $msg !== "";
			
			if(!$err) {
				if(editToolSupplier($_POST['exemplarnr'], $_POST['lieferantennr'], $_POST['anschaffungsdatum'], $_POST['anschaffungspreis'], $_POST['werkzeugnr'])) {
					$msg = 'Werkzeuglieferant geändert';
				} else {
					$msg = "Ein Fehler is aufgetreten";
					$err = true;
				}
			}
			?>
		<form method="post">
			<div class="result-message <?php echo ($err) ? "error-message" : "good-message"; ?>">
				<button type="submit">hide</button>
				<?php echo $msg; ?>
			</div>
		</form>
		<?php
		}

		if(isset($_POST['delete'])) {
			deleteToolSupplier($_POST['delete']);
			?>
			<form method="post">
				<div class="result-message good-message">
					<button type="submit">hide</button>
					Werkzeuglieferant (<?php echo $_POST['delete']; ?>) wurde gelöscht
				</div>
			</form>
			<?php
		}
	}
	?>
	<form method="post">
			<div class="table">
				<div class="table-row table-header-row">
					<div>Exemplarnr</div>
					<div><a class="header-link" href="/suppliers.php">Lieferant</a></div>
					<div>Datum</div>
					<div>Preis</div>
					<div><a class="header-link" href="/tools.php">Werkzeug</a></div>
					<div>Aktionen</div>
				</div>
			<?php
			foreach(getAllToolSuppliers() as $supplier) {
				?>
			<div class="table-row">
				<div><?php echo $supplier['exemplarnr']; ?></div>
				<div><?php echo getSupplierNameFromID($supplier['lieferantennr']); ?></div>
				<div><?php echo $supplier['anschaffungsdatum']; ?></div>
				<div><?php echo $supplier['anschaffungspreis']; ?></div>
				<div><?php echo getToolNameFromID($supplier['werkzeugnr']); ?></div>
				<div class="no-border actions">
					<div class="actions-grid">
					<?php if(toolsupplierCanBeDeleted($supplier['exemplarnr'])) { ?>
						<button type="submit" name="delete" value="<?php echo $supplier["exemplarnr"]; ?>">delete</button>
					<?php } else { ?>
						<button>not possible</button>
					<?php } ?>
						<button type="submit" name="edit" value="<?php echo $supplier["exemplarnr"]; ?>">edit</button>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
		</form>
	</main>
</body>
</html>
