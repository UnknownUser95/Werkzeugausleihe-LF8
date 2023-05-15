<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Workers</title>
<link rel="stylesheet" type="text/css" href="workers.css">
</head>
<body>
	<div class="table">
		<div class="table-header-row table-row">
			<div class="table-content table-header">ID</div>
			<div class="table-content table-header">Vorname</div>
			<div class="table-content table-header">Nachname</div>
			<div class="table-content table-header">Geburtsdatum</div>
		</div>
		<?php
		namespace werkzeugausleihe;
		use function werkzeugausleihe\getConnection;
		
		$conn = getConnection();

		$result = $conn->query("SELECT * FROM mitarbeiter");

		function output($row, $name) {
			echo "<div class='table-content'>".$row[$name]."</div>";
		}

		if($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "<div class='table-row'>";
				output($row, "mitarbeiternr");
				output($row, "vorname");
				output($row, "nachname");
				output($row, "geburtsdatum");
				echo "</div>";
			}
		}
		?>
	</div>
</body>
</html>
