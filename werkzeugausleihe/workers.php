<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Workers</title>
<link rel="stylesheet" type="text/css" href="workers.css">
</head>
<body>
<?php require_once './header.html'; ?>
	<div class="body">
<?php
require_once 'db/workers.php';
if($_SERVER["REQUEST_METHOD"] === "POST") {
	if(isset($_POST['edit'])) {
		$worker = getWorkerByID($_POST["edit"]);
		?>
	<form method="post">
			<div class="editor">
				<input type="hidden" name="mitarbeiternr" value="<?php echo $worker['mitarbeiternr']; ?>" />
				<div>
					<span>Vorname:</span>
					<input type="text" name="vorname" value="<?php echo $worker['vorname']; ?>" />
				</div>
				<div>
					<span>Nachname:</span>
					<input type="text" name="nachname" value="<?php echo $worker['nachname']; ?>" />
				</div>
				<div>
					<span>Geburtsdatum:</span>
					<input type="date" name="geburtsdatum" value="<?php echo $worker['geburtsdatum']; ?>" />
				</div>
				<button id="save-button" type="submit" name="edited" value="<?php echo $worker['mitarbeiternr']; ?>">save</button>
			</div>
		</form>
	<?php
	}

	if(isset($_POST['edited'])) {
		$msg = '';
		$err = false;
		if($_POST['geburtsdatum'] == '') {
			$msg = "date must not be empty";
			$err = true;
		} else {
			try {
				editWorker($_POST['mitarbeiternr'], $_POST['vorname'], $_POST['nachname'], $_POST['geburtsdatum']);
				$msg = "saved";
			} catch(mysqli_sql_exception $exc) {
				$err = true;
				$msg = "an error occured: ".$exc->getMessage();
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
		echo 'deleting '.$_POST['delete'];
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
					<div>actions</div>
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
							<button type="submit" name="delete" value="<?php echo $worker["mitarbeiternr"]; ?>">delete</button>
							<button type="submit" name="edit" value="<?php echo $worker["mitarbeiternr"]; ?>">edit</button>
						</div>
					</div>
				</div>
		<?php } ?>
		</div>
		</form>
	</div>
</body>
</html>
