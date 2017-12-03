<?php
	/**
	 * This is the landing page of the file uploader.
	 * Add a new file to the database.
	 */
	$db_file = '../../db/modular.db';
	$user_id = $_COOKIE["user_id"];
	if (isset($user_id)) {
		try {
			$db = new PDO('sqlite:' . $db_file);
			$file_name = basename($_FILES["fileToUpload"]["name"]);
			$path = $_FILES["fileToUpload"]["tmp_name"];
			$file_type = pathinfo($file_name, PATHINFO_EXTENSION); // uploaded file's extension
			$default_img_file = './img/default.png';
			if ($file_type != 'obj') {
				echo 'You must upload an .obj file.<br><br>';
				echo '<a href="."><button>Try again</button></a>';
			} else {
				$default_img = fread(fopen($default_img_file, "r"), filesize($default_img_file));
				$default_img = 'data:image/png;base64,' . base64_encode($default_img);
				$contents = file_get_contents($path);
				$creation_date = time();
				$default_name = basename($file_name, '.obj');
				// insert new model, default material (plastic) and color (white). parent_id is NULL since it wasn't forked
				$stmt = $db->prepare('INSERT INTO Model VALUES (NULL, ?, 2, 100, "#FFFFFF", ?, NULL, ?, ?, "My awesome model", ?);');
				$stmt->bindParam(1, $user_id);
				$stmt->bindParam(2, $contents);
				$stmt->bindParam(3, $default_name);
				$stmt->bindParam(4, $creation_date);
				$stmt->bindParam(5, $default_img);
				$success = $stmt->execute();
				if ($success) {
					echo 'Model created successfully.<br><br>';
					// get model id for the sake of moving to the editor
					$stmt = $db->prepare('SELECT model_id FROM Model WHERE creator_id = ? AND uploaded_date = ?;');
					$stmt->bindParam(1, $user_id);
					$stmt->bindParam(2, $creation_date);
					$stmt->execute();
					$model_id = $stmt->fetchAll()[0][0];
					echo '<a href="../editor/index.php?modelID=' . $model_id . '"><button>Edit your new model</button></a>';
				} else {
					echo 'There was a problem uploading';
				}
			}
		} catch (PDOException $e) {
			echo 'Sorry, there was a problem.';
		}
	} else {
		echo 'You must be signed in to upload a model.';
	}
?>
<br><br>
<a href="../index.php"><button>Return to homepage</button></a>