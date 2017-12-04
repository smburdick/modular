<?php
	$user_id  = $_COOKIE["user_id"];
?>

<?php
	//path to the SQLite database file
	$db_file = '../../db/modular.db';
	try {
		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $db->prepare("DELETE FROM Bookmarks WHERE user_id = ?");
		$stmt->bindParam(1, $user_id);
		
		$success = $stmt->execute();

		if ($success){
			echo '<h2>Your bookmarks were deleted</h2>
				  <h4>Click below to go back to your profile</h4>
				  <form action="profile.php">
					<input type="Submit" value="Go to your Profile">
				  </form>';
		}else{
			echo '<h2>Something went wrong</h2>
				  <h4> Please try again later</h4>
				  <form action="profile.php">
					<input type="Submit" value="Go to your Profile">
				  </form>';
		}
		
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>