<?php	
	echo '<h2>Please add your Credit Card Info Below</h2>
	<form action="inputCredit.php" method="post">
		Name on Card:<br>
		<input type="text" name="name_on_card"><span class="error"> * </span><br>
		Card Number:<br>
		<input type="text" name="card_number"><span class="error"> * </span><br>
		Expiration Date: <br>
		<input type="text" name="expiration_day">	<input type="text" name="expiration_month"><br>
		CCV: <br>
		<input type="text" name="state"><span class="error"> * </span><br><br>
		<input type="submit" value="Submit">
	</form>';
?>
