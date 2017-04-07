<?php 
/**
 * @param  object  $conn PDO object, tenging við gagnagrunn
 * @return int     fjöldi mynda í töflunni images
 */
function getCountOfImages($conn){

        $sql = 'SELECT * FROM images'; // select every record in the images table
        $result = $conn->query($sql);
        return $numRows = $result->rowCount();  // skilum fjölda mynda
}

/** 
 * @usage example:  $images = getAllImages($connection);
 * 
 * @param  object  $conn PDO object, tenging við gagnagrunn
 * @return object  allar myndir í formi objects
 */
function getAllImages($conn){

		// fyrirspurn
		$sql = 'SELECT id, image_name, image_path FROM images ORDER BY image_name';
        $query = $conn->prepare($sql);
        $query->execute();
        // sækjum allar raðir og skilum sem object.  
        $result = $query->fetchAll(PDO::FETCH_OBJ);     
        // Til að skila sem fylki þá notum við $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}

/**
 * @param  object  $conn PDO object, tenging við gagnagrunn
 * @param  int     $id  id af mynd.
 * @return object  upplýsingar um mynd.
 */
function getImageInfo($conn, $id){

        // fyrirspurn
        $sql = 'SELECT image_name, image_path, image_text FROM images WHERE id = :id';
        // notum prepared statements og binding parameters þegar við þurfum að senda inn parametra t.d. með select skipun
        $query = $conn->prepare($sql);
        // binding 
        $query->execute([':id' => $id]);
        // sækjum allar raðir og skilum sem object.  
        $result = $query->fetchAll(PDO::FETCH_OBJ);     
        // til að skila sem fylki þá notum við $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}

/**
 * @param  object  $conn PDO object, tenging við gagnagrunn
 * @return object  allar myndir í formi objects
 */
function getUserImages($conn, $id){

        // fyrirspurn
        $sql = 'SELECT image_name, image_path FROM images WHERE owner_id = :id ORDER BY image_name';
        $query = $conn->prepare($sql);
        $query->execute([':id' => $id]);
        // sækjum allar raðir og skilum sem object.  
        $result = $query->fetchAll(PDO::FETCH_OBJ);     
        // Til að skila sem fylki þá notum við $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}

/** 
 * @usage example:  $images = getAllImages($connection);
 * 
 * @param  object  $conn PDO object, tenging við gagnagrunn
 * @return object  allar myndir í formi objects
 */
function getAllUsers($conn){

        // fyrirspurn
        $sql = 'SELECT id, name FROM users ORDER BY name';
        $query = $conn->prepare($sql);
        $query->execute();
        // sækjum allar raðir og skilum sem object.  
        $result = $query->fetchAll(PDO::FETCH_OBJ);     
        // Til að skila sem fylki þá notum við $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}

/**
 * @param  object  $conn PDO object, tenging við gagnagrunn
 * @return int     id, image_path, image_name í töflunni images útfrá leitarskilyrðum.
 */
function search($conn, $search){

        //  PDO prepared statement in a search 
        $sql = 'SELECT id, image_path, image_name FROM images WHERE image_name LIKE :search';    
        $query = $conn->prepare($sql);  

        // % þýðir að við getum leitað hluta af myndheiti.
        $query->bindValue(':search', '%' . $search . '%');
        $query->execute();    
           
        $result = $query->fetchAll(PDO::FETCH_OBJ);     
        return $result;
}
?>