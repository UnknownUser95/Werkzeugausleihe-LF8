<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Mitarbeiter</title>
<link rel="stylesheet" type="text/css" href="./../c../ommon/all.css">
</head>
<body>
<?php require_once './../../header.html'; ?>
	<main>
	<?php
	require_once './../db/suppliers.php';
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST['edit'])) {
			$supplier = getSupplierByID($_POST["edit"]);
			?>
		<form method="post">
			<div class="editor">
				<input type="hidden" name="lieferantennr" value="<?php echo $supplier['lieferantennr']; ?>" />
				<div>
					<span>Firma:</span>
					<input type="text" name="firma" value="<?php echo $supplier['firma']; ?>" />
				</div>
				<div>
					<span>Name:</span>
					<input type="text" name="ansprechpartnerName" value="<?php echo $supplier['ansprechpartnerName']; ?>" />
				</div>
				<div>
					<span>Email:</span>
					<input type="text" name="ansprechpartnerEmail" value="<?php echo $supplier['ansprechpartnerEmail']; ?>" />
				</div>
				<div>
					<span>Telefon:</span>
					<input type="text" name="ansprechpartnerTelefon" value="<?php echo $supplier['ansprechpartnerTelefon']; ?>" />
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
			foreach(getAllSuppliers() as $supplier) {
				?>
			<div class="table-row">
					<div><?php echo $supplier['lieferantennr']; ?></div>
					<div><?php echo $supplier['firma']; ?></div>
					<div><?php echo $supplier['ansprechpartnerName']; ?></div>
					<div><?php echo $supplier['ansprechpartnerEmail']; ?></div>
					<div><?php echo $supplier['ansprechpartnerTelefon']; ?></div>
					<div class="no-border actions">
						<div class="actions-grid">
							<button type="submit" name="delete" value="<?php echo $supplier["lieferantennr"]; ?>">delete</button>
							<button type="submit" name="edit" value="<?php echo $supplier["lieferantennr"]; ?>">edit</button>
						</div>
					</div>
				</div>
		<?php } ?>
		</div>
		</form>
	</main>
</body>
</html>
