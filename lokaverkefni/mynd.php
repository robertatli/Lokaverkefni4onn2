<?php 
	require "connection.php";		// gagnagrunnstenging
	require "dbqueries.php";      // safn af föllum m.a. með db aðgerðir

	// sækjum id úr GET array
	$id = $_GET["id"];

	// notum db teningu og id til að sækja frekari upplýsingar um mynd.
	// $imgInfo geymir image_name, image_path, image_text
	$imgInfo = getImageInfo($conn, $id);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo htmlentities($imgInfo[0]->image_name); ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<!-- Birtum mynd og myndaupplýsingar. -->
   <figure>
   			<h1><?php echo htmlentities($imgInfo[0]->image_name); ?></h1>
		    <img src="img/<?php echo htmlentities($imgInfo[0]->image_path); ?>"/>
		    <figcaption><?php echo htmlentities($imgInfo[0]->image_text); ?></figcaption>
	</figure>   
		

</body>
</html>

