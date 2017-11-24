<!DOCTYPE html>
<html>
<body>
<p>
	
	<?php
		//path to the SQLite database file
		$db_file = '../../db/modular.db';
		try {
		//open connection to the user database file
		$db = new PDO('sqlite:' . $db_file);
		$f_name = $_POST['f_name'];
		$l_name = $_POST['l_name'];
		$username = $_POST['username']
		$missing_fn = false;
		$missing_ln = false;
		if ($f_name == '')
		$missing_fn = true;
		if ($l_name == '')
		$missing_ln = true;
		if ($missing_fn || $missing_ln) {
		header('Location: http://10.250.94.72/passengerForm.php?mf='. $missing_fn . '&ml='.$missing_ln . '&ms='.$missing_ssn.'&bs='.$bad_ssn );
		}
			//set errormode to use exceptions
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//return all passengers, and store the result set
			$stmt = $db->prepare("insert into passengers values (?, NULL, ?, ?);");
			$stmt->bindParam(1, $f_name);
			$stmt->bindParam(2, $l_name);
			$stmt->bindParam(3, $ssn);
			$stmt->execute();
			echo "It works!";
		//$stmt = $db->prepare("SELECT * FROM passengers where ssn = ?");
		/*if ($stmt->execute(array($_GET['ssn']))) {
		while ($row = $stmt->fetch()) {
			print_r($row);
		}
		}*/
			// $query_str2 = "select * from passengers where ssn='$_GET[ssn]';";
		//$result_set = $db->query($query_str2);
			//loop through each tuple in result set and print out the data
			//ssn will be shown in blue (see below)
		/*
			foreach($result_set as $tuple) {
				 echo "<font color='blue'>$tuple[ssn]</font> $tuple[f_name] $tuple[m_name] $tuple[l_name]<br/>\n";
			}
		*/
			//disconnect from db
			$db = null;
		}
		catch(PDOException $e) {
			die('Exception : '.$e->getMessage());
		}
	?>

</p>
</body>
</html>