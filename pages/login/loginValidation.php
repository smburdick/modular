<?php
	//path to the SQLite database file
	$db_file = '../../db/modular.db';
	try {

		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);
		$username = $_POST['username'];
		$password = $_POST['hashed_password'];
		$hashed_password = '';
		$missing_un = false;
		$missing_ps = false;
		$empty = '';
		if (strcmp($username, $empty) == 0){
			$missing_un = true;
		}
		if (strcmp($password, $empty) == 0){
			$missing_pw = true;
		}
		if ($missing_un){
			header('Location: http://localhost/modular/pages/login/login.php?mu=true');
		}
		if ($missing_pw){
			header('Location: http://localhost/modular/pages/login/login.php?mp=true');
		}
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//return all passengers, and store the result set
		$stmt = $db->prepare("select * from user where username == '?' and hashed_password == '?';");
		$stmt->bindParam(1, $username);
		$stmt->bindParam(2, $hashed_password);
		$stmt->execute();
		
		header('Location: http://localhost/modular/pages/profile/profile.php');

		$db = null;
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>