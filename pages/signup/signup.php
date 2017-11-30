<!DOCTYPE html>
<html lang="en">
<head>
	<title>Signup</title>
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
		<div class="col-sm-8 text-center"> 
			<h1>Welcome</h1>
			<h3>Please enter your information below</h3>
			<p><span class="error">* required field</span></p>
			<?php
			echo '<form action="inputSignup.php" method="post">
				First Name: <br>
				<input type="text" name="f_name" required> <span class="error"> * </span>
				<br>
				Last name: <br>
				<input type="text" name="l_name" required>  <span class="error"> * </span>
				<br>
				Email: <br>
				<input type="text" name="email" required>  <span class="error"> * </span>
				<br>
				Username: <br>
				<input type="text" name="username" required>  <span class="error"> * </span>
				<br>
				Password: <br>
				<input type="password" name="password" required>  <span class="error"> * </span>
				<br>
				Birthday:<br>
				(MM/DD/YYYY)<br>
				<input type="text" name="birth_month">     <input type="text" name="birth_day">      <input type="text" name="birth_year">
				<br>
				Biography: <br>
				<textarea name="bio" rows="5" cols="30"></textarea>
				<br>
				<input type="submit" value="Submit">
			</form>';
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

