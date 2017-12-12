<?php
	error_reporting(0);
	echo "<!DOCTYPE html>";
	echo "<html lang='en'>";
	include '../boilerplate.php';
	generate_head('Forked model', '');
?>
<body>

<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
	<div class="col-sm-8 text-left"> <br><br>
 <?php
  $model_id = $_GET['modelID'];
  $user_id = $_COOKIE['user_id'];
  if (!isset($user_id)) {
  	echo 'You must be signed in to fork a model.';
  } else {
  	$db_path = '../../db/modular.db';
  	try {
	  	$db = new PDO('sqlite:' . $db_path);
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $model_stmt = $db->prepare("SELECT * FROM Model WHERE model_id = ?;");
	    $model_stmt->bindParam(1, $model_id);
	    $model_stmt->execute();
	    $model = $model_stmt->fetchAll()[0];
	    $model_stmt = $db->prepare("INSERT INTO Model VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
	    $model_stmt->bindParam(1, $user_id);
	    $model_stmt->bindParam(2, $model["material_id"]);
	    $model_stmt->bindParam(3, $model["mass_in_grams"]);
	    $model_stmt->bindParam(4, $model["color_hex"]);
	    $model_stmt->bindParam(5, $model["object_file"]);
	    $model_stmt->bindParam(6, $model_id);
	    $model_stmt->bindParam(7, $model["model_name"]);
	    $uploaded_date = time();
	    $model_stmt->bindParam(8, $uploaded_date);
	    $model_stmt->bindParam(9, $model["description"]);
	    $model_stmt->bindParam(10, $model["image"]);
	    $success = $model_stmt->execute();
	    if ($success) {
	    	echo 'Model successfully forked.<br><br>';
	    	$stmt = $db->prepare('SELECT model_id FROM Model WHERE creator_id = ? AND uploaded_date = ?;');
			$stmt->bindParam(1, $user_id);
			$stmt->bindParam(2, $uploaded_date);
			$stmt->execute();
			$model_id = $stmt->fetchAll()[0][0];
			echo '<a href="../editor/index.php?modelID=' . $model_id . '"><button>Edit your new model</button></a>';
	    } else {
	    	echo 'There was a problem forking to the database.';
	    }
	    

  	} catch(PDOException $e){
      die('Exception : ' . $e->getMessage());
  	}
  }
?>
</div>
<div class="col-sm-2 sidenav">
		</div>
</div>
</body>
</html>