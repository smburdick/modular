<?php
	$username = $_COOKIE['username'];
	include '../boilerplate.php';
    echo '<!DOCTYPE html>
	<html lang="en">';
    generate_head('Signup', '');
?>
<html lang="en">

<body>

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
				Verify Password: <br>
				<input type="password" name="verify_password" required>  <span class="error"> * </span>
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

</body>
</html>

