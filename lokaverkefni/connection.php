<?php

$source = 'mysql:host=localhost;dbname=1802992039_v5';
$user = 'root';
$passw = 'robbi123';

// Sjá nánar um PDO t.d.: http://www.sitepoint.com/re-introducing-pdo-the-right-way-to-access-databases-in-php/ 
try {
	$conn = new PDO($source, $user, $passw);   
 	# Notum utf-8 og gerum það með SQL fyrirspurn exec sendir sql fyrirspurnir til database
 	$conn->exec('SET NAMES "utf8"');

} catch (PDOException $e) {
		echo 'Tenging mistókst: ' . $e->getMessage();
}