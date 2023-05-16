<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Workers</title>
<link rel="stylesheet" type="text/css" href="workers.css">
</head>
<body>
	<form method="post" action="delete_workers.php">
		<div class="table">
			<div class="table-row table-header-row">
				<div>ID</div>
				<div>Vorname</div>
				<div>Nachname</div>
				<div>Geburtsdatum</div>
				<div>X</div>
			</div>
			<?php
			require_once 'db/connection.php';
			$result = query("SELECT * FROM mitarbeiter");
			while($row = $result->fetch_assoc()) {
				?>
			<div class="table-row">
				<div><?php echo $row['mitarbeiternr']; ?></div>
				<div><?php echo $row['vorname']; ?></div>
				<div><?php echo $row['nachname']; ?></div>
				<div><?php echo $row['geburtsdatum']; ?></div>
				<div>
					<input type='checkbox' name='selected[]' value='<?php echo $row['mitarbeiternr']; ?>'></input>
				</div>
			</div>
		<?php } ?>
		</div>
		<input type="submit" value="delete" class="submit"></input>
	</form>
</body>
</html>
