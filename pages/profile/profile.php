<?php
	$username = $_COOKIE['username'];
	include '../boilerplate.php';
    echo '<!DOCTYPE html>
	<html lang="en">';
    generate_head('Your Profile', 'profile');
?>
<html lang="en">
	
<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left"> 
			<div class="col-sm-4">
				
			</div>
			<div class="col-sm-8 text-left">
				<?php
					$db_file = '../../db/modular.db';
					$db = new PDO('sqlite:' . $db_file);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$checkingUsername = '';
					if (!isset($_GET['username'])){
						$checkingUsername = $username;
					}else{
						$checkingUsername = $_GET['username'];
					}
					
					$data = 0;
					$success = '';
					$stmt = $db->prepare("SELECT * FROM user WHERE username = ? ;");
					$stmt->bindParam(1, $checkingUsername);
					$success = $stmt->execute();
					$data = $stmt->fetchAll();

					if ($success){
						echo '
						<h1>'.$data[0]['f_name'].' '.$data[0]['l_name'].'</h1>
						<h3>@'.$data[0]['username'].'</h3>
						<h4>Birthday: '.$data[0]['birth_month'].'/'.$data[0]['birth_day'].'/'.$data[0]['birth_year'].'</h4>
						<h4> Biography:</h4>
						<p>'.$data[0]['bio'];
						echo '<form action="../profile/updateProfile.php">
								<input type="Submit" value="Edit your Profile">
							</form>';
					}

					//$db = null;
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
			<?php
				echo "<div class=\"card-deck\">";
					$stmt = $db->prepare("SELECT * FROM user WHERE username = ? ;");
					$stmt->bindParam(1, $username);
					$success = $stmt->execute();
					$data = $stmt->fetchAll();

		 
				  $query = "SELECT * FROM Model WHERE creator_id == " . $data[0][0];
				  $new_results = $db->query($query);
				  foreach($new_results as $tuple) {
					?>
					  <div class="card" style="max-width: 350px; min-width: 350px; width: 300px; margin-bottom: 20px">
						<div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
						<img class="card-img-top" src="../review/homer.png" alt="Card image cap">
						<div class="card-body">
						  <?php
						  echo "<h4 class=\"card-title\">   $tuple[model_name]</h4>";

						  echo "<a href=\"../product/product.php\" class=\"card-link\">View Model</a>";
						  echo "</div>";
						  echo "<div class=\"card-footer\"><small class=\"text-muted\">$tuple[category_id]</small></div>";
						  ?>
					</div>
					<?php
				  }
				echo "</div>";
			?>
		</div>
		<div class="col-sm-2 sidenav">
		</div>

	</div>
</div>

</body>
</html>

