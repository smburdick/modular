<!DOCTYPE html>
<html>
<body>
<p>
	
	<?php

		//path to the SQLite database file
		$db_file = '../../db/modular.db';
		try {
			//open connection to the user database file
			$db = new PDO('sqlite:' . $db_file);
			$f_name = $_POST['f_name'];
			$l_name = $_POST['l_name'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$bio = $_POST['bio'];
			$birth_day = $_POST['birth_day'];
			$birth_month = $_POST['birth_month'];
			$birth_year = $_POST['birth_year'];
			$password = $_POST['password'];
			$photo = $_POST['photo'];

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			
			//set errormode to use exceptions
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//return all passengers, and store the result set
			$stmt = $db->prepare("insert into user values (NULL, ?, ?, ?, ?, ?, ?, ?, ?);");
			$stmt->bindParam(1, $username);
			$stmt->bindParam(2, $f_name);
			$stmt->bindParam(3, $l_name);
			$stmt->bindParam(4, $birth_day);
			$stmt->bindParam(5, $birth_month);
			$stmt->bindParam(6, $birth_year);
			$stmt->bindParam(7, $bio);
			$stmt->bindParam(8, $hashed_password);
			//$stmt->bindParam(9, $photo);
			$stmt->execute();
			
			//header('Location: http://localhost/modular/pages/profile/profile.php');

			$db = null;
		}
		catch(PDOException $e) {
			die('Exception : '.$e->getMessage());
		}
	?>

</p>
</body>
</html>