<!DOCTYPE html>
<html>
<body>
<p>
	
	<?php

		//path to the SQLite database file
		$db_file = '../../db/modular.db';
		try {

			// define variables and set to empty values
			$usernameErr = $passwordErr = "";
			$username = $password = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			  if (empty($_POST["username"])) {
			    $usernameErr = "Username is required";
			  } else {
			    $username = test_input($_POST["username"]);
			  }

			  if (empty($_POST["password"])) {
			    $passwordErr = "Password is required";
			  } else {
			    $password = test_input($_POST["password"]);
			  }
			}
			//open connection to the user database file
			$db = new PDO('sqlite:' . $db_file);
			$username = $_POST['username'];
			$password = $_POST['password'];
			$missing_un = false;
			$missing_ps = false;
			if ($username == '')
				$missing_un = true;
			if ($password == '')
				$missing_pw = true;
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			$cookie_name = "user";
			$cookie_value = $username;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			
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

</p>
</body>
</html>