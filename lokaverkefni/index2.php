<?php 

	// set the maximum upload size in bytes
	 $max = 51200;
	 if (isset($_POST['upload'])) {
	 // define the path to the upload folder
	 $destination = 'upload_files/';
	 require_once 'Upload.php';
		 try {
		 	$loader = new Upload($destination);
		 	$loader->setMaxSize($max);
		 	$loader->allowAllTypes();
		 	$loader->upload();
		 	$result = $loader->getMessages();
		 } catch (Exception $e) {
		 	echo $e->getMessage();
		 }
	 }
	 if (isset($_POST['upload']) && $_FILES['image']['size'] > 0) {
	 	$fileName = $_FILES['image']['name'];
		$tmpName  = $_FILES['image']['tmp_name'];
		$imageName = $_POST['imageNameInfo'];
		$imageText = $_POST['imageDescInfo'];
		$owner_id = 1;


		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
		    $fileName = addslashes($fileName);
		}
		require 'connection.php';

		$sql = "INSERT INTO images(owner_id, image_name, image_path, image_text)VALUES(:owner_id,:image_name,:image_path,:image_text)";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':owner_id'=>$owner_id, ':image_name'=>$imageName, ':image_path'=>$fileName, ':image_text'=>$imageText));

		if ($stmt->rowCount() == 1) {
        	$success = "Mynd hefur verið uploaduð í database";
    	}else{
    		echo "<br>File $fileName not uploaded<br>";
    	}

		
	 }

	require "connection.php";
	require "dbqueries.php";
	
	// liður 3. c) athugum hvort smellt var á leitarreit
	if (isset($_GET['go'])){
		// sækjum input úr leitarreit $_GET['search'] og filterum með t.d. filter_input 
		// sjá nánar http://www.phptherightway.com/#data_filtering
		$search = filter_input(INPUT_GET,'search',FILTER_SANITIZE_STRING);  
		// sækjum fjölda niðurstaðna úr leit
		$searchedImages = search($conn, $search);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Verkefni 5</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php include 'includes/menu.php' ?>
<div class="site">

		<!--
			2. a)  heildarfjöldi mynda úr töflunni myndir úr gagnagrunni.
				PHP Solution 11-4: Counting records in a result set (PDO)
		-->
			<p> Heildarfjöldi mynda: <?php echo htmlentities(getCountOfImages($conn)); ?> </p>

		
		<!--
			2. b)	Sjá allar myndir sem linkar. Raðaðu þeim upp sem lista í stafrófsröð eftir myndheitum.
				PHP Solution 11-5: Displaying the images table using PDO
		-->	
			<?php
				/*	Sækjum myndaupplýsingar frá gagnagrunni, fallið þarf að fá db tenginguna til að PDO aðgerðir virki. */
				$images = getAllImages($conn);  
				// getum skoðað með print_r($images); eða ef við viljum bara skoða id á fyrstu röð í images töflu þá echo $images[0]->id;
			?>

			<!-- birtum lista af öllum myndum -->
			<ul>
				<?php
	        	foreach ($images as $row) {
		            // einfaldur linkur á mynd 
		            // echo "<li><a href=img/$row->image_path>" . $row->image_name . "</a></li>";
		    
		            // linkur á vefsíðu sem geymir frekari upplýsingar um mynd. Við sendum id á mynd með GET REQUEST þegar notandi smellir á link.
		    	?>        
		       		<li><a href=mynd.php?id=<?php echo htmlentities($row->id);?>><?php echo htmlentities($row->image_name);?></a></li>
	        	<?php
	        	}
				?>
			</ul>

		<!--
		 	2. c) Þegar smellt er á link þá opnast ný vefsíða með myndinni, myndheiti og lýsingu.
			   Sjá útfærslu í mynd.php
		-->

		<!--
			3. a) Birtu notendur á vefsíðu í lista. 
		-->	
			<p>Notendur:</p>
			<?php
				/*	Sækjum notendur */
				$users = getAllUsers($conn);  
			?>
			<!-- birtum lista af notendum -->
			<ul>
				<?php
	        	foreach ($users as $row) {
		            // linkur á vefsíðu sem geymir allar myndir notanda. Við sendum id á user með GET REQUEST þegar notandi smellir á link.
		    	?>        
		       		<li><a href=user.php?id=<?php echo htmlentities($row->id);?>><?php echo htmlentities($row->name);?></a></li>
	        	<?php
	        	}
				?>
			</ul>
		<!--
			3. b) Þegar smellt er á ákveðinn notanda t.d. Hildi þá eiga myndirnar hennar að birtast. (frjáls útfærsla á birtingamáta)
				Sjá t.d. PHP Solution 11-6: Inserting an integer from user input into a query
			   
			    Sjá útfærslu í user.php
		-->

		<!--
			3. c) Búðu til leitarreit þar sem hægt er að leita eftir myndheiti eða part af myndheiti. Birtu valda mynd-ir. Sjá PHP Solution 11-9: Using a PDO prepared statement in search
		 -->

		 	<!-- leitarreitur -->
			<form method="get" action="">
			    <input type="search" name="search" id="search">
			    <input type="submit" name="go" value="Search">
			</form>

			<!-- Birtum fjölda niðurstaðna úr leit -->
			<?php if (isset($searchedImages)) { ?>
		    	<p>Number of results for <strong><?php echo htmlentities($search); ?></strong>: <?php echo htmlentities(count($searchedImages)); ?></p>
			<?php } ?>

			<!-- Birtum  mynd-ir úr leit --> 
			<?php
			if (isset($searchedImages)){
			   foreach ($searchedImages as $img) {
			   ?>
		   		<figure>
				    <img src="upload_files/<?php echo $img->image_path;?>"/>
				    <figcaption><?php echo htmlentities($img->image_name);?></figcaption>
				</figure>   
			<?php
			   }
			}
			?>

		<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
			 <p>
				 <label for="image">Upload image:</label>
				 <input type="hidden" name="MAX_FILE_SIZE" value="<?= $max; ?>">
				 <input type="file" name="image" id="image">
			 </p>
			 <p>
			 	 <label for="imageNameInfo">Image Name:</label>
			 	 <input type="text" name="imageNameInfo" id="imageNameInfo" required><br>
			 	 <label for="imageDescInfo">Image Description:</label>
			 	 <textarea type="text" name="imageDescInfo" id="imageDescInfo" cols="40" rows="5" required></textarea>
			 </p>
			 <p>
				 <input type="submit" name="upload" id="upload" value="Upload">
			 </p>
			 
		</form>

			<?php
				if (isset($result)) {
				 	echo '<ul>';
				 	foreach ($result as $message) {
				 		echo "<li>$message</li>";
				 	}
				 	echo '</ul>';
				 } 
			 ?>

</div>
</body>
</html>