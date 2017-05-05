<?php 
	require_once 'connection.php';
	// hversu margir dálkar eru í table
	define('COLS', 2);
	// búa til breytur fyrir looper
	$pos = 0;
	$firstRow = true;

	// setja magn mynda í einu
	define('SHOWMAX', 6);

	// prepare SQL to get total records
	$getTotal = 'SELECT COUNT(*) FROM images';
	// submit query and store result as $totalPix
	$total = $conn->query($getTotal);
	$totalPix = $total->fetchColumn();

	//stillir síðuna
	if (isset($_GET['curPage'])) {
		$curPage = $_GET['curPage'];
	}else{
		$curPage = 0;
	}

	//Reikna byrjunar línuna
	$startRow = $curPage * SHOWMAX;
	if ($startRow > $totalPix) {
		$startRow = 0;
		$curPage = 0;
	}

	$sql = "SELECT image_path, image_text FROM images LIMIT $startRow," . SHOWMAX;
	// sendi inn beðnina
	$result = $conn->query($sql);
	$errorInfo = $conn->errorInfo();
	if (isset($errorInfo[2])) {
	    $error = $errorInfo[2];
	} else {
	    // Næ í fyrsta file og set það í array
	    $row = $result->fetch();
	    // Nær í nafn og description hjá myndinni
	    if (isset($_GET['image'])) {
	        $mainImage = $_GET['image'];
	    } else {
	        $mainImage = $row['image_path'];
	    }
	    if (file_exists('upload_files/'.$mainImage)) {
	        // get the dimensions of the main image
	        $imageSize = getimagesize('upload_files/'.$mainImage)[3];
	    } else {
	        $error = 'Image not found.';
	    }
	}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Gallery</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php require 'includes/menu.php'; ?>
<div class="site">
    <h1>Myndir</h1>    
    <main>
        <h2>Myndir</h2>
        <?php if (isset($error)) {
            echo "<p>$error</p>";
        } else {
            ?>
            <p id="picCount">Mynd <?php echo $startRow+1;
                if ($startRow+1 < $totalPix) {
                    echo ' til ';
                    if ($startRow+SHOWMAX < $totalPix) {
                        echo $startRow+SHOWMAX;
                    } else {
                        echo $totalPix;
                    }
                }
                echo " af $totalPix";
                ?>
            </p>
            <div id="gallery">
                <table id="thumbs">
                    <tr>
                        <!--This row needs to be repeated-->
                        <?php
                        do {
                            // set image_text if thumbnail is same as main image
                            if ($row['image_path'] == $mainImage) {
                                $image_text = $row['image_text'];
                            }
                            // if remainder is 0 and not first row, close row and start new one
                            if ($pos++ % COLS === 0 && !$firstRow) {
                                echo '</tr><tr>';
                            }
                            // once loop begins, this is no longer true
                            $firstRow = false;
                            ?>
                            <td><a href="<?= $_SERVER['PHP_SELF']; ?>?image=<?=$row['image_path']; ?>&amp;curPage=<?= $curPage; ?>"><img class="thumb" src="upload_files/<?= $row['image_path']; ?>" alt="="<?= $row['image_text']; ?>" width="54" height="54"></a></td>
                        <?php } while ($row = $result->fetch());
                        while ($pos++ % COLS) {
                            echo '<td>&nbsp;</td>';
                        }
                        ?>
                    </tr>
                    <!-- Navigation link needs to go here -->
                    <tr><td>
                            <?php
                            // create a back link if current page greater than 0
                            if ($curPage > 0) {
                                echo '<a href="' . $_SERVER['PHP_SELF'] . '?curPage=' . ($curPage-1) .
                                    '"> &lt; Prev</a>';
                            } else {
                                // otherwise leave the cell empty
                                echo '&nbsp;';
                            }
                            ?>
                        </td>
                        <?php
                        // pad the final row with empty cells if more than 2 columns
                        if (COLS-2 > 0) {
                            for ($i = 0; $i < COLS-2; $i++) {
                                echo '<td>&nbsp;</td>';
                            }
                        }
                        ?>
                        <td>
                            <?php
                            // create a forward link if more records exist
                            if ($startRow+SHOWMAX < $totalPix) {
                                echo '<a href="' . $_SERVER['PHP_SELF'] . '?curPage=' . ($curPage+1) .
                                    '"> Next &gt;</a>';
                            } else {
                                // otherwise leave the cell empty
                                echo '&nbsp;';
                            }
                            ?>
                        </td></tr>
                </table>
                <figure id="main_image">
                    <img src="upload_files/<?= $mainImage; ?>" alt="<?= $image_text; ?>" class="galleryImage" ?>
                    <figimage_text><?= $image_text; ?></figimage_text>
                </figure>
            </div>
        <?php } ?>
    </main>
</div>
</div>
</body>
</html>