<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Mitarbeiter</title>
<link rel="stylesheet" type="text/css" href="./../common/all.css">
</head>
<body>
<?php require_once './../header.html'; ?>
	<main>
	<?php
	require_once './../db/workers.php';
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST['edit'])) {
			$worker = getWorkerByID($_POST["edit"]);
			?>
		<form method="post">
			<div class="editor">
				<input required type="hidden" name="mitarbeiternr" value="<?php echo $worker['mitarbeiternr']; ?>" />
				<div>
					<span>Vorname:</span>
					<input required type="text" name="vorname" value="<?php echo $worker['vorname']; ?>" />
				</div>
				<div>
					<span>Nachname:</span>
					<input required type="text" name="nachname" value="<?php echo $worker['nachname']; ?>" />
				</div>
				<div>
					<span>Geburtsdatum:</span>
					<input required type="date" name="geburtsdatum" value="<?php echo $worker['geburtsdatum']; ?>" />
				</div>
				<div id="buttons">
					<button type="submit" name="edited" value="<?php echo $worker['mitarbeiternr']; ?>">speichern</button>
					<button type="submit" name="cancel" value="<?php echo $worker['mitarbeiternr']; ?>">abbrechen</button>
				</div>
			</div>
		</form>
		<?php
		}

		if(isset($_POST['edited'])) {
			require_once './../common/functions.php';
			$msg = verify(FULL_WORKER_ARGS);
			$err = $msg !== "";
			
			if(!$err) {
				if(editWorker($_POST['mitarbeiternr'], $_POST['vorname'], $_POST['nachname'], $_POST['geburtsdatum'])) {
					$msg = 'Mitarbeiter geändert';
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
			deleteWorker($_POST['delete']);
			?>
			<form method="post">
				<div class="result-message good-message">
					<button type="submit">hide</button>
					Mitarbeiter (<?php echo $_POST['delete']; ?>) wurde gelöscht
				</div>
			</form>
			<?php
		}
	}
	?>
	<form method="post">
			<div class="table">
				<div class="table-row table-header-row">
					<div>ID</div>
					<div>Vorname</div>
					<div>Nachname</div>
					<div>Geburtsdatum</div>
					<div>Aktionen</div>
				</div>
			<?php
			foreach(getAllWorkers() as $worker) {
				?>
			<div class="table-row">
					<div><?php echo $worker['mitarbeiternr']; ?></div>
					<div><?php echo $worker['vorname']; ?></div>
					<div><?php echo $worker['nachname']; ?></div>
					<div><?php echo $worker['geburtsdatum']; ?></div>
					<div class="no-border actions">
						<div class="actions-grid">
							<?php if(workerCanBeDeleted($worker['mitarbeiternr'])) { ?>
								<button type="submit" name="delete" value="<?php echo $worker["mitarbeiternr"]; ?>">delete</button>
							<?php } else { ?>
								<button>not possible</button>
							<?php } ?>
							<button type="submit" name="edit" value="<?php echo $worker["mitarbeiternr"]; ?>">edit</button>
						</div>
					</div>
				</div>
		<?php } ?>
		</div>
		</form>
	</main>
</body>
</html>
