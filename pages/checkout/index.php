<?php

	$checking_out = $_POST["checking_out"];
	$user_id = $_COOKIE["user_id"];
	if ($checking_out && isset($user_id)) {
		try {
			$db_file = '../../db/modular.db';
          	$db = new PDO('sqlite:'.$db_file);
          	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          	$stmt = $db->prepare('SELECT * FROM InCart WHERE user_id = ?;');
	        $stmt->bindParam(1, $user_id);

	        $success = $stmt->execute();

	        $cart_subtotal = 0;

	        if ($success) {
	        	$result_set = $stmt->fetchAll();
	        	$time = time();
	        	foreach($result_set as $tuple) {
	        		$stmt = $db->prepare('INSERT INTO Purchases VALUES (?, ?, ?, ?);');
	        		$stmt->bindParam(1, $tuple["user_id"]);
	        		$stmt->bindParam(2, $tuple["model_id"]);
	        		$stmt->bindParam(3, $time);
	        		$stmt->bindParam(4, $tuple["quantity"]);
	        		$stmt->execute();
	        	}
	        }

          	$stmt = $db->prepare('DELETE FROM InCart WHERE user_id = ?;');
          	$stmt->bindParam(1, $user_id);
          	$stmt->execute();
          	$db = null;
          	echo '<h2>Thank you</h2>Your order should arrive soon.';

		} catch (PDOException $e) {
			die('Exception: ' . $e->getMessage());
		}
	} else {
		echo 'Error';
	}
?>
<br><br>
<a href="../"><button>Return to homepage</button></a>