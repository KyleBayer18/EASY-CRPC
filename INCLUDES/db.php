<?php
function db_connect(){


	 // $connection = pg_connect("host=localhost port=5432 dbname=group10_db
	 // 			user=group10_admin password=password");
		$connection = pg_connect("host=localhost dbname=CRPC
				user=bayerk password=password");
	return $connection;
}
?>