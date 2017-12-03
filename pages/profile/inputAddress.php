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

		$address_line_one = $_POST['address_line_one'];
		$address_line_two = $_POST['address_line_two'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipcode = $_POST['zipcode'];
		$country = $_POST['country'];

		$stmt = $db->prepare("INSERT INTO Address VALUES (?,null,?,?,?,?,?,?);");
		$stmt->bindParam(1, $user_id);
		$stmt->bindParam(2, $address_line_one);
		$stmt->bindParam(3, $address_line_two);
		$stmt->bindParam(4, $city);
		$stmt->bindParam(5, $state);
		$stmt->bindParam(6, $zipcode);
		$stmt->bindParam(7, $country);
		$success = $stmt->execute();

		if ($success){
			echo '<h2>Your address was saved</h2>
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