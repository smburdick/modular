<?php
	echo '<!DOCTYPE html>';
	echo '<html>';
 	include '../boilerplate.php';
    generate_head('Editor', '');

echo '<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left"> 
			<h2>Please add your Address Below</h2>
			<form action="inputAddress.php" method="post">
				Address 1:<br>
				<input type="text" name="address_line_one" required><span class="error"> * </span><br>
				Address 2:<br>
				<input type="text" name="address_line_two"><br>
				City: <br>
				<input type="text" name="city" required><span class="error"> * </span><br>
				State: <br>
				<input type="text" name="state" required><span class="error"> * </span><br>
				Zipcode: <br>
				<input type="text" name="zipcode" required><span class="error"> * </span><br>
				Country: <br>
				<input type="text" name="country" required><span class="error"> * </span><br><br>
				<input type="submit" value="Submit">
			</form>
		</div>
		<div class="col-sm-2 sidenav">
	</div>
</div>';
echo '</html>';

?>
