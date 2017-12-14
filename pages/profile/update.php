<?php
	$originalUsername = $_COOKIE['username'];
	$cookie_name = "username";
	$username = $_POST['username'];
	setcookie($cookie_name, $username, time() + 86400, '/');
	setcookie("user_id", $_COOKIE["user_id"], time() + 86400, '/');
?>

<?php
	//path to the SQLite database file
	$db_file = '../../db/modular.db';
	try {
		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		$f_name = $_POST['f_name'];
		$l_name = $_POST['l_name'];
		$username = $_POST['username'];
		$bio = $_POST['bio'];
		$birth_day = $_POST['birth_day'];
		$birth_month = $_POST['birth_month'];
		$birth_year = $_POST['birth_year'];
		$email = $_POST['email'];

		$stmt = $db->prepare("UPDATE user SET username = ?, f_name = ?, l_name = ?, bio = ?, birth_month = ?, birth_year = ?, birth_day = ?, email = ? WHERE username = ?");
		$stmt->bindParam(1, $username);
		$stmt->bindParam(2, $f_name);
		$stmt->bindParam(3, $l_name);
		$stmt->bindParam(4, $bio);
		$stmt->bindParam(5, $birth_month);
		$stmt->bindParam(6, $birth_year);
		$stmt->bindParam(7, $birth_day);
		$stmt->bindParam(8, $email);
		$stmt->bindParam(9, $originalUsername);
		$success = $stmt->execute();

		if ($success){
			echo '<!DOCTYPE html>';
			echo '<html>';
			include '../boilerplate.php';
   			generate_head('Profile updated', '');
			echo '<div class="container-fluid text-center">    
				<div class="row content">
					<div class="col-sm-2 sidenav">
					</div>
					<div class="col-sm-8 text-left"> 
						<h2>Your profile has been updated</h2>
						<form action="../profile/profile.php">
							<input type="Submit" value="Go to your Profile">
						</form>
					</div>
					<div class="col-sm-2 sidenav">
					</div>
				</div>
			</div>';
			echo '</html>';
		}else{
			echo '<!DOCTYPE html>';
			echo '<html>';
			include '../boilerplate.php';
   			generate_head('Editor', '');
			echo '<div class="container-fluid text-center">    
				<div class="row content">
					<div class="col-sm-2 sidenav">
					</div>
					<div class="col-sm-8 text-left"> 
						<h2> Something went wrong!</h2>
						<h4>Please try again later.</h4>
						<form action="profile.php">
							<input type="Submit" value="Go to your Profile"
					</div>
					<div class="col-sm-2 sidenav">
					</div>
				</div>
			</div>';
			echo '</html>';
			echo'';
		}
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>