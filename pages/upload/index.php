<?php
    // testing zone
    $testUserID = 0; // Sam's test user ID
    setcookie("userID", $testUserID, time() + 86400*30); // 86400 = 1 day
    //$_COOKIE["userID"] = $testUserID; // necessary?
?>
<!--
	Allows the user to upload a new model obj file.
	If the file successfully uploads, point them to the editor.
-->
<?php
	$user_id  = $_COOKIE["userID"];
	if (isset($user_id)) {
		echo '<h1>Upload a new model</h1>';
		echo '<form action="upload-result.php" method="post" enctype="multipart/form-data">';
		echo '<p>Object file: (must be a <code>.obj</code> file)</p>';
		echo '<input type="file" name="fileToUpload" id="fileToUpload">';
		echo '<input type="submit" value="Upload OBJ File" name="submit">';

		echo '</form>';
	} else {
		echo 'You must be signed in to upload a model.';
	}
?>

