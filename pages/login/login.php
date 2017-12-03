<!doctype html>
<head>
	<title>Modular</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "../css/style.css" /> 
</head>
<body>

<nav class="navbar-inverse" style="color: #BDBEBF">
	<div class="container-fluid">
		<div class="navbar-header" style= "max-height: 30px; display: block; margin: 0 auto;">
			<img src="../../logo/modular_logo.png" href="#" style="max-height: 45px"></img>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			
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
