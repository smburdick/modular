<?php
	$username = $_COOKIE['username'];
	include '../boilerplate.php';

?>
<!-- Source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_temp_webpage&stacked=h -->
<!DOCTYPE html>
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
					$stmt = $db->prepare("SELECT * FROM user WHERE username = ? ");
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
				}
				?>
			</div>
		</div>
		<div class="col-sm-2 sidenav">
			<!--
			<div class="well">
				<p>ADS</p>
			</div>
			<div class="well">
				<p>ADS</p>
			</div>
		-->
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
	<p align="left">2017 Modular</p>
</footer>

</body>
</html>

