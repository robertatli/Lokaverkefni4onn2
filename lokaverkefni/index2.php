<?php 
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
</head>
<body>

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
				    <img src="img/<?php echo $img->image_path;?>"/>
				    <figcaption><?php echo htmlentities($img->image_name);?></figcaption>
				</figure>   
			<?php
			   }
			}
			?>
</body>
</html>