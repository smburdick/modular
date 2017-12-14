<?php
	echo '<!DOCTYPE html>';
	echo '<html>';
 	include '../boilerplate.php';
    generate_head('Adding banking info', '');

echo '<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left"> 
		<h2>Please add your Credit Card Info Below</h2>
			<form action="inputCredit.php" method="post">
				Name on Card:<br>
				<input type="text" name="name_on_card"><span class="error"> * </span><br>
				Card Number:<br>
				<input type="text" name="card_number"><span class="error"> * </span><br>
				Expiration Date (MM/YY): <br>
				<input type="text" name="expiration_month">	<input type="text" name="expiration_year"><span class="error"> * </span><br>
				CCV: <br>
				<input type="text" name="ccv"><span class="error"> * </span><br><br>
				<input type="submit" value="Submit">
			</form>
		</div>
		<div class="col-sm-2 sidenav">
	</div>
</div>';
echo '</html>';

?>
