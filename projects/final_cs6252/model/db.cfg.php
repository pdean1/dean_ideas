<?php
/*
 * This is the database configuration file.
 */
$dsn = 'mysql:host=localhost;dbname=marketplace';
$username = 'mp_user'; 
$password = 's3cr3t';	
try {
	$marketplaceDB = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
	$errorMessage = $e->getMessage();
	display_error($errorMessage);
}