<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/include/log.inc.php';
	
	if( isset( $_GET['action'] ) && $_GET['action']=='logout' ) {
		session_destroy();
		//echo json_encode(array('location'=>'home'));
	}
		
	//print_r( $_SESSION );
	if(!isset($_SESSION['login_user'])){
		header('Location: /');
	}
	
	include $_SERVER['DOCUMENT_ROOT'].'/include/connect.inc.php';

	if( isset( $_GET['action'] ) && $_GET['action'] == 'list' ) {
		
		list_part();
	}

	/*
		List of active parts from database table.
		**mySql  
			SELECT * FROM tbPart WHERE ACTIVE
	*/
	function list_part() {
		// get database connection object
		$pdo = dbConnect();
		try {
			$sql = 'SELECT
						tbPart.id AS "PID",  
			 			tbPart.descr AS "DESCRIPTION", 
			 			tbPart.image AS "IMAGE",
						IFNULL(tbDrawing.drawing_number,"") AS "DRAWING"
			 		FROM tbPart
			 		LEFT JOIN tbDrawing ON tbPart.id = tbDrawing.partid
			 		ORDER BY PID';
			$s = $pdo->prepare($sql);
			$s -> execute();
			$results = $s -> fetchAll();
			$th = array('PID', 'DESCRIPTION', 'DRAWING' );
		}
		catch (PDOException $e) {
			$error =  'Error getting Type list:<br>'.	
						$e->getMessage();
			echo $error;
		}
		header('Content-Type: application/json');
		echo json_encode($results);
	}

	// /*
	//	// DONT FORGET TO SCRIPT INJECTION PROTECTION!
	// 	Insert new part into database table.
	//   $description - is the item description
	//   $ext - the image file type ie the file extension '.jpg', '.jpeg', '.gif'
		
	// 	**mySQL
	// 	  INSERT INTO tbPart (descr, image) VALUES ($description, $image)
	// */
	// function insert($description, $ext) {
	// 	// get database connection object
	// 	$pdo = $dbConnect();
	// 	// concantenate the next id value and the file extension to 
	// 	// produce the filename
	// 	$next_id =  get_last_id() + 1 ;

	// 	$filename = $next_id.$ext;
	// 	try {
	// 			$sql = 'INSERT INTO tbPart (descr, image) VALUES ( :descr, :image )';	
	// 			$s = $pdo -> prepare($sql);
	// 			$s -> bindValue(':descr', $descr, PDO::PARAM_STR);
	// 			$s -> bindValue(':image', $filename, PDO::PARAM_STR);
	// 			$s -> execute();
	// 			$last_id = $pdo -> lastInsertId();
				
	// 			// log insert
	// 			append_log('#'.$last_id.' added to part number table');
	// 			// just log event if the image file name is not the 
	// 			// same as the id inserted into the table
	// 			if ($last_id != $next_id) {
	// 				append_log('#'.$filename.' is linked to #'.$last_id);
	// 			}
	// 		} 
	// 		catch (PDOException $e) {
	// 			$error =  'Insert part failed with following error:<br>'.	
	// 									$e->getMessage();
	// 			echo $error;
	// 		}
	// 	}
	// }

	// // edit database table detail using id value.
	// function edit($id) {

	// }

	// // returns the last id value in table
	// function get_last_id() {
	// 	// get the last id value so that we can rename the image file
	// 	try {
	// 			$sql = 'SELECT MAX(id) AS "NEXT_ID" FROM tbPart FOR UPDATE';
	// 			$stmt = $pdo->query($sql);
	// 			$row = $stmt->fetch();
	// 			$last_id = $row['NEXT_ID'];
	// 		}
	// 		catch (PDOException $e) {
	// 			$error =  'Failed to count parts'.	
	// 				$e->getMessage();
	// 			echo $error;
	// 		}
	// 	return $last_id;
	// }

?>