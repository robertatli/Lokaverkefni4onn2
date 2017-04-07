<?php 
	require "connection.php";		// gagnagrunnstenging
	require "dbqueries.php";      // safn af föllum m.a. með db aðgerðir

	// sækjum id úr GET array, ef það er til (smellt á einhvern user)
	if (isset($_GET['id'])){
		$id = $_GET["id"];
		// $skilar image_name og image_path
		$userImages = getUserImages($conn, $id);
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Users</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<!-- Birtum allar myndir og myndheiti sem notandi á. -->
	<?php
	if (isset($userImages)){
	   foreach ($userImages as $user) {
	   ?>
   		<figure>
		    <img src="img/<?php echo htmlentities($user->image_path);?>"/>
		    <figcaption><?php echo htmlentities($user->image_name);?></figcaption>
		</figure>   
	<?php
	   }
	}
	?>

</body>
</html>