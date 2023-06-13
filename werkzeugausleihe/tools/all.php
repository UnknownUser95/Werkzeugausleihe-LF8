<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Werkzeuge</title>
<link rel="stylesheet" type="text/css" href="./../common/all.css">
</head>
<body>
<?php require_once './../header.html'; ?>
	<main>
	<?php
	require_once './../db/tools.php';
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(isset($_POST['edit'])) {
			$tool = getToolByID($_POST["edit"]);
			?>
		<form method="post">
			<div class="editor">
				<input type="hidden" name="werkzeugnr" value="<?php echo $tool['werkzeugnr']; ?>" />
				<div>
					<span>Bezeichnung:</span>
					<input required type="text" name="bezeichnung" value="<?php echo $tool['bezeichnung']; ?>" />
				</div>
				<div>
					<span>Beschreibung:</span>
					<input required type="text" name="beschreibung" value="<?php echo $tool['beschreibung']; ?>" />
				</div>
				<div id="buttons">
					<button type="submit" name="edited" value="<?php echo $tool['werkzeugnr']; ?>">speichern</button>
					<button type="submit" name="cancel" value="<?php echo $tool['werkzeugnr']; ?>">abbrechen</button>
				</div>
			</div>
		</form>
		<?php
		}

		if(isset($_POST['edited'])) {
			require_once './../common/functions.php';
			$msg = verify(FULL_TOOL_ARGS);
			$err = $msg !== "";
			
			if($msg === "") {
				if(editTool($_POST['werkzeugnr'], $_POST['bezeichnung'], $_POST['beschreibung'])) {
					$msg = 'Werkzeug geändert';
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
			deleteTool($_POST['delete']);
			?>
			<form method="post">
				<div class="result-message good-message">
					<button type="submit">hide</button>
					Werkzeug (<?php echo $_POST['delete']; ?>) wurde gelöscht
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
					<div>Bezeichnung</div>
					<div>Beschreibung</div>
					<div>Aktionen</div>
				</div>
			<?php
			foreach(getAllTools() as $tool) {
				?>
			<div class="table-row">
					<div><?php echo $tool['werkzeugnr']; ?></div>
					<div><?php echo $tool['bezeichnung']; ?></div>
					<div><?php echo $tool['beschreibung']; ?></div>
					<div class="no-border actions">
						<div class="actions-grid">
							<?php if(toolCanBeDeleted($tool['werkzeugnr'])) { ?>
								<button type="submit" name="delete" value="<?php echo $tool["werkzeugnr"]; ?>">delete</button>
							<?php } else { ?>
								<button>not possible</button>
							<?php } ?>
							<button type="submit" name="edit" value="<?php echo $tool["werkzeugnr"]; ?>">edit</button>
						</div>
					</div>
				</div>
		<?php } ?>
		</div>
		</form>
	</main>
</body>
</html>
