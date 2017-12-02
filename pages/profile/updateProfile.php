<?php
	$username = $_COOKIE['username'];
?>
<?php
	//path to the SQLite database file
	$db_file = '../../db/modular.db';
	try {
		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);

		
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//return all passengers, and store the result set
		$stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
		$stmt->bindParam(1, $username);
		$success = $stmt->execute();
		$returnedValues = $stmt->fetchAll();
		$userid = $returnedValues[0][0];
		$username = $returnedValues[0][1];
		$f_name = $returnedValues[0][2];
		$l_name = $returnedValues[0][3];
		$birth_day = $returnedValues[0][4];
		$birth_month = $returnedValues[0][5];
		$birth_year = $returnedValues[0][6];
		$bio = $returnedValues[0][7];
		$email = $returnedValues[0][9];

		echo '<form action="update.php" method="post">
				First Name: <br>
				<input type="text" name="f_name" value="'.$f_name.'"> <span class="error"> * </span>
				<br>
				Last name: <br>
				<input type="text" name="l_name" value="'.$l_name.'">  <span class="error"> * </span>
				<br>
				Email: <br>
				<input type="text" name="email" value="'.$email.'" required>  <span class="error"> * </span>
				<br>
				Username: <br>
				<input type="text" name="username" value="'.$username.'"required>  <span class="error"> * </span>
				<br>
				Birthday:<br>
				(MM/DD/YYYY)<br>
				<input type="text" name="birth_month" value="'.$birth_month.'">     <input type="text" name="birth_day" value="'.$birth_day.'">      <input type="text" name="birth_year" value="'.$birth_year.'">
				<br>
				Biography: <br>
				<textarea name="bio" rows="5" cols="30">'.$bio.'</textarea>
				<br>
				<input type="submit" value="Submit">
			</form>';


		$db = null;
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>