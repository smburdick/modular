
<!DOCTYPE html>
<html lang="en">
<?php
	// From here the use can select their address and banking info.
  include '../boilerplate.php';
  generate_head('Checkout', '');
?>
<body>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left"> <br><br>
    <h2>Checkout</h2><br>
<?php

	$checking_out = $_POST["checking_out"];
	$user_id = $_COOKIE["user_id"];
	if ($checking_out && isset($user_id)) {
		try {
			$db_file = '../../db/modular.db';
          	$db = new PDO('sqlite:'.$db_file);
          	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          	// get the user addresses
          	$stmt = $db->prepare('SELECT * FROM Address WHERE user_id = ?;');
          	$stmt->bindParam(1, $user_id);
          	$stmt->execute();
          	$addresses = $stmt->fetchAll();
          	// get the banking account info
          	$stmt = $db->prepare('SELECT * FROM BankingInfo WHERE user_id = ?;');
          	$stmt->bindParam(1, $user_id);
          	$stmt->execute();
          	$banking_infos = $stmt->fetchAll();

          	$db = null;

		} catch (PDOException $e) {
			die('Exception: ' . $e->getMessage());
		}
	} else {
		echo 'Error';
	}
	
?>
	<form action="checkout.php" method="post">
			<?php
			echo '<b>Shipping Address: </b><select>';
			foreach ($addresses as $address) {
				echo '<option name="shipping_address" value="' . $address["address_id"] . '">' . $address["address_line_one"] . '   ' . $address["address_line_two"] . '   ' . $address["city"] .'</option>' ;
			}
			echo '</select><br><br>';
			echo '<b>Banking Info: </b><select>';
			foreach ($banking_infos as $info) {
				echo '<option name="banking_info" value="' . $info["banking_info_id"] . '">' . $info["name_on_card"] . '   ' . $info["card_number"] . '   ' . $info["ccv"] .'</option>' ;
			}
			echo '</select><br><br>';
			echo '<b>Billing Address: </b><select>';
			foreach ($addresses as $address) {
				echo '<option name="billing_address" value="' . $address["address_id"] . '">' . $address["address_line_one"] . '   ' . $address["address_line_two"] . '   ' . $address["city"] .'</option>' ;
			}
			echo '</select>';
			?>
			<br><br>
			<input type="hidden" name="checking_out" value="true">
			<input type="submit" value="Submit">
    </form>
	</div>
	</div>
</div>
</body>
</html>