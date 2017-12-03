<?php
	$username = $_COOKIE['username'];

?>
<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "../css/style.css" /> 
</head>
<body>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="#">Modular</a> <!-- TODO logo -->
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#">Cart</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php
					if (isset($_COOKIE['username'])){
						echo '<li><a href="../profile/profile.php">Profile</a></li>';
					}else{
						echo '<li><a href="../login/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
					}
				?>
			</ul>
		</div>
	</div>
</nav>
	
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

<footer class="container-fluid text-center">
	<p align="left">2017 Modular</p>
</footer>

</body>
</html>

