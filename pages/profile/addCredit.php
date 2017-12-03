<?php	
	echo '<h2>Please add your Credit Card Info Below</h2>
	<form action="inputAddress.php" method="post">
		Card Number:<br>
		<input type="text" name="card_number"><span class="error"> * </span><br>
		:<br>
		<input type="text" name="address_line_two"><span class="error"> * </span><br>
		City: <br>
		<input type="text" name="city"><span class="error"> * </span><br>
		State: <br>
		<input type="text" name="state"><span class="error"> * </span><br>
		Zipcode: <br>
		<input type="text" name="zipcode"><span class="error"> * </span><br>
		Country: <br>
		<input type="text" name="country"><span class="error"> * </span><br><br>
		<input type="submit" value="Submit">
	</form>';
?>
