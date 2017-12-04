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
		$photo = $_POST['photo'];
		$emailAddress = $_POST['email'];
		$verify_password = $_POST['verify_password'];
		$default_image = '../profile/empty_profile_img.png';

		if (strcmp($password, $verify_password) !== 0){
			echo '<!DOCTYPE html>';
				echo '<html>';
				include '../boilerplate.php';
	   			generate_head('Editor', '');
				echo '<div class="container-fluid text-center">    
					<div class="row content">
						<div class="col-sm-2 sidenav">
						</div>
						<div class="col-sm-8 text-left"> 
							<h2>The passwords that you entered did not match</h2>
							  <h4>Click below to try again</h4>
							  <form action="signup.php">
								<input type="Submit" value="Try Again">
							  </form>
						</div>
						<div class="col-sm-2 sidenav">
						</div>
					</div>
				</div>';
				echo '</html>';
		}
		else{
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			//set errormode to use exceptions
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$checkUsername = $db->prepare("SELECT * FROM user WHERE username = ?");
			$checkUsername->bindParam(1, $username);
			$ifPresent = $checkUsername->execute();
			$data = $checkUsername->fetchAll();

			if (strcmp($username, $data[0][1]) !== 0){
				$stmt = $db->prepare("insert into user values (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
				$stmt->bindParam(1, $username);
				$stmt->bindParam(2, $f_name);
				$stmt->bindParam(3, $l_name);
				$stmt->bindParam(4, $birth_day);
				$stmt->bindParam(5, $birth_month);
				$stmt->bindParam(6, $birth_year);
				$stmt->bindParam(7, $bio);
				$stmt->bindParam(8, $hashed_password);
				$stmt->bindParam(9, $emailAddress);
				$stmt->bindParam(10, $default_image);
				$stmt->execute();
				$data = $stmt->fetchAll();

				$stmt = $db->prepare('SELECT user_id FROM user WHERE username = ?;');
				$stmt->bindParam(1, $username);
				$stmt->execute();
				$user_id = $stmt->fetchAll()[0][0];

				setcookie("user_id", $user_id, time() + 86400, '/');
				setcookie("username", $username, time() + 86400, '/');

				echo '<!DOCTYPE html>';
				echo '<html>';
				include '../boilerplate.php';
	   			generate_head('Editor', '');
				echo '<div class="container-fluid text-center">    
					<div class="row content">
						<div class="col-sm-2 sidenav">
						</div>
						<div class="col-sm-8 text-left"> 
							<h1>Your Account was created!</h1>
								<h3>Click here to go to your profile page:</h3>
								<form action="../profile/profile.php">
									<input type="Submit" value="Visit your new Profile">
								</form>
						</div>
						<div class="col-sm-2 sidenav">
						</div>
					</div>
				</div>';
				echo '</html>';
			}
			else{
				echo '<!DOCTYPE html>';
				echo '<html>';
				include '../boilerplate.php';
	   			generate_head('Editor', '');
				echo '<div class="container-fluid text-center">    
					<div class="row content">
						<div class="col-sm-2 sidenav">
						</div>
						<div class="col-sm-8 text-left"> 
							<h2>This username is already taken.</h2><p>Click the button below to try again.</p><br>
							<form action="signup.php">
								<input type="Submit" value="Try Again">
							</form>
						</div>
						<div class="col-sm-2 sidenav">
						</div>
					</div>
				</div>';
				echo '</html>';
			}
		}
		

		$db = null;
	}
	catch(PDOException $e) {
		die('Exception : '.$e->getMessage());
	}
?>