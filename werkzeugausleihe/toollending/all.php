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
	require_once './../db/toollendings.php';
	require_once './../db/toolsuppliers.php';
	require_once './../db/workers.php';
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST['edit'])) {
			$data = explode("|", $_POST['edit']);
			$toolLending = getToolLendingByID($data[0], $data[1], $data[2]);
			?>
		<form method="post">
			<div class="editor">
				<input type="hidden" name="exemplarnr" value="<?php echo $toolLending['exemplarnr']; ?>" />
				<div>
					<span>Exemplarnr:</span>
					<select required name="exemplarnr">
					<?php foreach(getAllToolSuppliers() as $baseToolSupplier) {?>
						<option value="<?php echo $baseToolSupplier['exemplarnr'];?>" <?php if($baseToolSupplier['exemplarnr'] === $toolLending['exemplarnr']) { echo 'selected="selected"'; } ?>><?php echo formatToolSupplierResult($baseToolSupplier); ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Mitarbeiter:</span>
					<select required name="mitarbeiternr">
					<?php foreach(getAllWorkers() as $baseWorker) {?>
						<option value="<?php echo $baseWorker['mitarbeiternr'];?>" <?php if($baseWorker['mitarbeiternr'] === $toolLending['mitarbeiternr']) { echo 'selected="selected"'; } ?>><?php echo getWorkerNameFromResult($baseWorker); ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Ausleihdatum:</span>
					<input required type="date" name="ausleihdatum" value="<?php echo $toolLending['ausleihdatum']; ?>" />
				</div>
				<div>
					<span>Rückgabedatum:</span>
					<input required type="date"name="rueckgabedatum" value="<?php echo $toolLending['rueckgabedatum']; ?>" />
				</div>
				<div>
					<span>Rückgegeben Am:</span>
					<input type="date" name="zurueckgegebenam" value="<?php echo $toolLending['zurueckgegebenam']; ?>" />
				</div>
				<div id="buttons">
					<button type="submit" name="edited" value="edited">speichern</button>
					<button type="submit" name="cancel">abbrechen</button>
				</div>
			</div>
		</form>
		<?php
		}

		if(isset($_POST['edited'])) {
			require_once './../common/functions.php';
			
			$msg = verify(FULL_TOOL_LENDING_ARGS, TOOL_LENDING_NULLABLE_ARGS);
			$err = $msg !== "";
			
			if(!$err) {
				if(fullEdit($_POST['exemplarnr'], $_POST['mitarbeiternr'], $_POST['ausleihdatum'], $_POST['rueckgabedatum'], $_POST['zurueckgegebenam'])) {
					$msg = 'Werkzeugausleihe geändert';
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
			$data = explode("|", $_POST['delete']);
			$toolLending = getToolLendingByID($data[0], $data[1], $data[2]);
			
			$err = deleteToolLending($toolLending['exemplarnr'], $toolLending['mitarbeiternr'], $toolLending['ausleihdatum']);
			
			$msg = "Ein Fehler ist aufgetreten";
			if(!$err) {
				$name = getWorkerNameFromID($toolLending[]);
				$msg = "Werkzeugausleihe ({$toolLending['exemplarnr']}|{$name}|{$toolLending['ausleihdatum']}) gelöscht";
			}
			
			?>
			<form method="post">
				<div class="result-message <?php echo $err ? "good-message" : "error-message" ?>">
					<button type="submit">hide</button>
					<?php echo $msg; ?>
				</div>
			</form>
			<?php
		}
	}
	?>
	<form method="post">
			<div class="table">
				<div class="table-row table-header-row">
					<div><a class="header-link" href="/werkzeugausleihe/toolsuppliers/all.php">Exemplarnr</a></div>
					<div><a class="header-link" href="/werkzeugausleihe/workers/all.php">Mitarbeiter</a></div>
					<div>Ausleihdatum</div>
					<div>Rückgabe</div>
					<div>Rückgegeben Am</div>
					<div>Aktionen</div>
				</div>
			<?php
			foreach(getAllToollendings() as $toolLending) {
				?>
			<div class="table-row">
				<div><?php echo $toolLending['exemplarnr']; ?></div>
				<div><?php echo getWorkerNameFromID($toolLending['mitarbeiternr']); ?></div>
				<div><?php echo $toolLending['ausleihdatum']; ?></div>
				<div><?php echo printNullableDate($toolLending['rueckgabedatum']); ?></div>
				<div><?php echo printNullableDate($toolLending['zurueckgegebenam']); ?></div>
				<div class="no-border actions">
					<div class="actions-grid">
						<?php $payload = "{$toolLending['exemplarnr']}|{$toolLending['mitarbeiternr']}|{$toolLending['ausleihdatum']}"; ?>
						<button type="submit" name="delete" value="<?php echo $payload; ?>">delete</button>
						<button type="submit" name="edit" value="<?php echo $payload; ?>">edit</button>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
		</form>
	</main>
</body>
</html>
