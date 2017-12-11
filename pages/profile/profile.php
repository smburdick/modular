<?php
	$username = $_COOKIE['username'];
	include '../boilerplate.php';
	echo '<!DOCTYPE html><html lang="en">';

					$db_file = '../../db/modular.db';
					$db = new PDO('sqlite:' . $db_file);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$checkingUsername = '';
					$profileType = '';
					if (!isset($_GET['username']) || ($_GET['username'] == $username)){
						$checkingUsername = $username;
						$profileType = 'my_profile';
					} else {
						$checkingUsername = $_GET['username'];
						$profileType = 'other_profile';
					}

					generate_head($checkingUsername . '\'s Profile', $profileType);

			echo '			
			<div class="container-fluid text-center">    
				<div class="row content">
					<div class="col-sm-2 sidenav">
					</div>
					<div class="col-sm-8 text-left"> 
						<div class="col-sm-4">';
					
					$data = 0;
					$success = '';
					$stmt = $db->prepare("SELECT * FROM user WHERE username = ? ;");
					$stmt->bindParam(1, $checkingUsername);
					$success = $stmt->execute();
					$data = $stmt->fetchAll();
					if (sizeof($data) != 0){

				echo '<br>
				<center><img src="'.$data[0]['photo'].'" style="height: 75%; width: 75%"><br><br>
				<!--<form action="uploadImage.php">
					<input type="Submit" value="Upload a Profile Image">
				</form>-->
				</center>
			</div>
			<div class="col-sm-8 text-left">';

					if ($success){
						echo '
						<h1>'.$data[0]['f_name'].' '.$data[0]['l_name'].'</h1>
						<h3>@'.$data[0]['username'].'</h3>
						<h4>Birthday: '.$data[0]['birth_month'].'/'.$data[0]['birth_day'].'/'.$data[0]['birth_year'].'</h4>
						<h4> Biography:</h4>
						<p>'.$data[0]['bio'];
						if (!isset($_GET['username'])){
							echo '<br><form action="../profile/updateProfile.php">
								<input type="Submit" value="Edit your Profile">
							</form><br>';
							echo '<br><form action="../profile/addAddress.php">
								<input type="Submit" value="Add an Address">
							</form><br><br>';
							echo '<form action="../profile/addCredit.php">
								<input type="Submit" value="Add a Credit Card">
							</form>';
						}
					}
				}else{
					echo '<h2>This user does not exist.</h2>
						<h4>Please check your information and try agian.</h4>';
				}
				?>
			</div>
		</div>
		<div class="col-sm-2 sidenav">
		</div>
	</div>
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left">
			<hr>
			<h3>Models</h3>
			<center><br>
			<?php
				$checkingUsername = '';
				if (!isset($_GET['username'])){
					$checkingUsername = $username;
				}else{
					$checkingUsername = $_GET['username'];
				}
				echo "<div class=\"card-deck\">";
					$stmt = $db->prepare("SELECT * FROM user WHERE username = ? ;");
					$stmt->bindParam(1, $checkingUsername);
					$success = $stmt->execute();
					$data = $stmt->fetchAll();

		 
				  $query = "SELECT * FROM Model WHERE creator_id == " . $data[0][0];
				  $new_results = $db->query($query);
				  foreach($new_results as $tuple) {
					?>
					  <div class="card" align="center" style="max-width: 300px; min-width: 300px; width: 300px; margin-bottom: 20px">
						<div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
						<?php
						echo '<img class="card-img-top" src="'.$tuple['image'].'">
						<div class="card-body">';
						  
						  echo "<h4 class=\"card-title\">   $tuple[model_name]</h4>";

						  echo "<a href=\"../product/product.php?id=".$tuple['model_id']."\" class=\"card-link\">View Model</a>";
						  echo "</div>";
						  ?>
					</div>
					<?php
				  }
				echo "</div>";
			?>
		</center>
		</div>
		<div class="col-sm-2 sidenav">
		</div>

	</div>
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left">
			<?php
			echo '<hr>
			<h3>Bookmarks</h3><form action="deleteBookmarks.php">
				<input type="Submit" value="Delete all Bookmarks">
			</form>
			<center><br>';
			echo "<div class=\"card-deck\">";
			$stmt = $db->prepare("SELECT * FROM user WHERE username = ? ;");
			$stmt->bindParam(1, $checkingUsername);
			$success = $stmt->execute();
			$data = $stmt->fetchAll();	 
			$new_results = $db->prepare("SELECT * FROM Bookmarks NATURAL JOIN Model WHERE user_id = ?;");
			$new_results->bindParam(1, $data[0][0]);
			$new_results->execute();
			$newdata = $new_results->fetchAll();
			foreach($newdata as $tuple) {
				?>
				  <div class="card" align="center" style="max-width: 300px; min-width: 300px; width: 300px; margin-bottom: 20px">
					<div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
					<?php
					echo '<img class="card-img-top" src="'.$tuple['image'].'">
					<div class="card-body">';
					  
					  echo "<h4 class=\"card-title\">   $tuple[model_name]</h4>";

					  echo "<a href=\"../product/product.php?id=".$tuple['model_id']."\" class=\"card-link\">View Model</a>";
					  echo "</div>";
					  ?>
				</div>
				<?php
			  }
			echo "</div>";
		?>
		</center>
		</div>
		<div class="col-sm-2 sidenav">
		</div>

	</div>
</div>

</body>
</html>

