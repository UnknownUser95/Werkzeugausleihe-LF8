<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Werkzeugausleihe erstellen</title>
<link rel="stylesheet" type="text/css" href="./../common/create.css">
</head>
<body>
	<?php require_once './../header.html'; ?>
	<main>
		<?php
		require_once './../common/functions.php';
		require_once './../db/toollendings.php';
		require_once './../db/toolsuppliers.php';
		require_once './../db/workers.php';
		
		$unavailableTools = getUnavailableTools();
		
		if(!isset($_POST['ausleihdatum'])) {
			$_POST['ausleihdatum'] = date('Y-m-d', time());
		}
		
		setIfNotDefined(SHOULD_BE_SET_TOOL_LENDING_ARGS);
		?>
		<form method="post">
			<div class="editor">
				<div>
					<span>Exemplarnr:</span>
					<select required name="exemplarnr">
					<?php foreach(getAllToolSuppliers() as $baseSupplier) {
						if(in_array($baseSupplier['exemplarnr'], $unavailableTools)) {
							continue;
						}
						?>
						<option value="<?php echo $baseSupplier['exemplarnr'];?>" <?php if($baseSupplier['exemplarnr'] === $_POST['exemplarnr']) { echo 'selected="selected"'; } ?>><?php echo formatToolSupplierResult($baseSupplier); ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Mitarbeiter:</span>
					<select required name="mitarbeiternr">
					<?php foreach(getAllWorkers() as $baseWorker) {?>
						<option value="<?php echo $baseWorker['mitarbeiternr'];?>" <?php if($baseWorker['mitarbeiternr'] === $_POST['mitarbeiternr']) { echo 'selected="selected"'; } ?>><?php echo getWorkerNameFromResult($baseWorker); ?></option>
					<?php } ?>
					</select>
				</div>
				<div>
					<span>Ausleihdatum:</span>
					<input required type="date" name="anschaffungsdatum" value="<?php echo $_POST['ausleihdatum']; ?>" />
				</div>
				<div>
					<span>Rückgabe:</span>
					<input type="date" name="rueckgabedatum" value="<?php echo $_POST['rueckgabedatum']; ?>" />
				</div>
				<button id="save-button" type="submit" name="save" value="save">save</button>
			</div>
		</form>
		<?php
		if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])) {
			$msg = verify(TOOL_LENDING_ARGS);
			$err = $msg !== "";
			
			if($msg === "") {
				if(createToolLending($_POST['exemplarnr'], $_POST['mitarbeiternr'], $_POST['ausleihdatum'], $_POST['rueckgabedatum'])) {
					$msg = 'Werkzeugausleihe erstellt';
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
