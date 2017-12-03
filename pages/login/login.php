<?php
	$username = $_COOKIE['username'];
	include '../boilerplate.php';
    echo '<!DOCTYPE html>
	<html lang="en">';
    generate_head('Upload New Model', 'Upload');
?>
<!doctype html>
<body>

<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<?php

			echo '<div class="col-sm-4 text-center">
				<form action="loginValidation.php" method="post">
					<br>
					<h1>Login</h1>
					<label><b>Username</b></label>
					<input type="text" name="username" placeholder="Enter Username" required><br>

					<label><b>Password</b></label>
					<input type="password" name="password" placeholder="Enter Password" required><br><br>

					<button type="submit">Login</button>
				</form>
		</div>'
		?>
	<div class="col-sm-4 text-center">
		<br>
		<h1>Sign Up</h1>
		<h4>Click below to set up an account</h4><br>
		<form action="../signup/signup.php">
			<button type="submit" name="Go to Sign Up">Signup</button>
		</form>
	</div>
		<div class="col-sm-2 sidenav">
			
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
	<p align="left">2017 Modular</p>
</footer>

</body>
<html>
