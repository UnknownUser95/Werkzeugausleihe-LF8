<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Lieferanten</title>
<link rel="stylesheet" type="text/css" href="./../common/all.css">
</head>
<body>
<?php require_once './../header.html'; ?>
	<main>
	<?php
	require_once './../db/suppliers.php';
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST['edit'])) {
			$toolLending = getSupplierByID($_POST["edit"]);
			?>
		<form method="post">
			<div class="editor">
				<input required type="hidden" name="lieferantennr" value="<?php echo $toolLending['lieferantennr']; ?>" />
				<div>
					<span>Firma:</span>
					<input required type="text" name="firma" value="<?php echo $toolLending['firma']; ?>" />
				</div>
				<div>
					<span>Name:</span>
					<input required type="text" name="ansprechpartnerName" value="<?php echo $toolLending['ansprechpartnerName']; ?>" />
				</div>
				<div>
					<span>Email:</span>
					<input required type="text" name="ansprechpartnerEmail" value="<?php echo $toolLending['ansprechpartnerEmail']; ?>" />
				</div>
				<div>
					<span>Telefon:</span>
					<input required type="text" name="ansprechpartnerTelefon" value="<?php echo $toolLending['ansprechpartnerTelefon']; ?>" />
				</div>
				<div id="buttons">
					<button type="submit" name="edited" value="<?php echo $toolLending['lieferantennr']; ?>">speichern</button>
					<button type="submit" name="cancel" value="<?php echo $toolLending['lieferantennr']; ?>">abbrechen</button>
				</div>
			</div>
		</form>
		<?php
		}

		if(isset($_POST['edited'])) {
			require_once './../common/functions.php';
			$msg = verify(FULL_SUPPLIER_ARGS);
			$err = $msg !== "";
			
			if(!$err) {
				if(editSupplier($_POST['lieferantennr'], $_POST['firma'], $_POST['ansprechpartnerName'], $_POST['ansprechpartnerEmail'], $_POST['ansprechpartnerTelefon'])) {
					$msg = 'Lieferant geändert';
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
			deleteSupplier($_POST['delete']);
			?>
			<form method="post">
				<div class="result-message good-message">
					<button type="submit">hide</button>
					Lieferant (<?php echo $_POST['delete']; ?>) wurde gelöscht
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
					<div>Firma</div>
					<div>Name</div>
					<div>Email</div>
					<div>Telefon</div>
					<div>Aktionen</div>
				</div>
			<?php
			foreach(getAllSuppliers() as $toolLending) {
				?>
			<div class="table-row">
					<div><?php echo $toolLending['lieferantennr']; ?></div>
					<div><?php echo $toolLending['firma']; ?></div>
					<div><?php echo $toolLending['ansprechpartnerName']; ?></div>
					<div><?php echo $toolLending['ansprechpartnerEmail']; ?></div>
					<div><?php echo $toolLending['ansprechpartnerTelefon']; ?></div>
					<div class="no-border actions">
						<div class="actions-grid">
							<button type="submit" name="delete" value="<?php echo $toolLending["lieferantennr"]; ?>">delete</button>
							<button type="submit" name="edit" value="<?php echo $toolLending["lieferantennr"]; ?>">edit</button>
						</div>
					</div>
				</div>
		<?php } ?>
		</div>
		</form>
	</main>
</body>
</html>
