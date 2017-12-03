<?php
	$username = $_POST['username'];
	//path to the SQLite database file
	$db_file = '../../db/modular.db';
	try {
		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);
		// if (isset($_COOKIE['username']))
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashed_password = '';
		
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//return all passengers, and store the result set
		$stmt = $db->prepare("SELECT * FROM user WHERE username = ?;");
		$stmt->bindParam(1, $username);
		$success = $stmt->execute();
		$returnedValues = $stmt->fetchAll();

		if (strcmp($returnedValues[0][1], $username) !== 0 && password_verify($password, $returnedValues[0][8]) !== 0){
			echo '<h2>The information you entered is wrong.</h2><p>Click the button below to try again.</p><br>';
			echo '<form action="login.php">
					<input type="Submit" value="Try Again">
				  </form>';
		}else{
			setcookie("username", $username, time() + 86400*30, '/');
			setcookie("user_id", $returnedValues[0][0], time() + 86400*30, '/');

			echo '<h2>You are now logged in!</h2> <br> <h4> Click below to go to your profile</h4><br>';
			echo '<form action="../profile/profile.php">
					<input type="Submit" value="Go to your Profile">
				  </form>';
			
		}

		$db = null;
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>