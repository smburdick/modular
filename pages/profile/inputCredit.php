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

		$name_on_card = $_POST['name_on_card'];
		$card_number = $_POST['card_number'];
		$ccv = $_POST['ccv'];
		$expiration_month = $_POST['expiration_month'];
		$expiration_year = $_POST['expiration_year'];

		$stmt = $db->prepare("INSERT INTO BankingInfo VALUES (null,?,?,?,?,?,?);");
		$stmt->bindParam(1, $user_id);
		$stmt->bindParam(2, $card_number);
		$stmt->bindParam(3, $ccv);
		$stmt->bindParam(4, $name_on_card);
		$stmt->bindParam(5, $expiration_month);
		$stmt->bindParam(6, $expiration_year);
		
		$success = $stmt->execute();

		if ($success){
			echo '<h2>Your credit card was saved</h2>
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