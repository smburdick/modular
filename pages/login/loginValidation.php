
<?php
	//path to the SQLite database file
	$db_file = '../../db/modular.db';
	try {
		if (isset($_COOKIE['username'])){
			header('Location: http://localhost/modular/pages/profile/profile.php');
		}

		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);
		// if (isset($_COOKIE['username']))
		$username = $_POST['username'];
		$password = $_POST['hashed_password'];
		$hashed_password = '';
		
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//return all passengers, and store the result set
		$stmt = $db->prepare("select * from user where username == '".$username."' and hashed_password == '".$hashed_password."';");
		// $stmt->bindParam(1, $username);
		// $stmt->bindParam(2, $hashed_password);
		$stmt->execute();

		//echo $stmt;
		
		header('Location: http://localhost/modular/pages/profile/profile.php');

		$db = null;
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>