<?php
	// valutiamo se far creare il DB direttamente alla pagina
	if(!is_file('access.sqlite')){
		file_put_contents('access.sqlite', null);
	}
	// mi connetto
	$conn = new PDO('sqlite:access.sqlite');
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// idem come sopra, facciamo creare la tabella direttamente alla pagina
	$query = "CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT UNIQUE, password TEXT, tempo DATETIME, auth INTEGER)";
	$conn->exec($query);
?>
