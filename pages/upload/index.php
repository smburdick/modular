<?php
    // testing zone
    $testUserID = 0; // Sam's test user ID
    setcookie("user_id", $testUserID, time() + 86400*30); // 86400 = 1 day
    include '../boilerplate.php';
    echo '<!DOCTYPE html>
	<html lang="en">';
    generate_head('Upload New Model', 'Upload');
?>
<!--
	Allows the user to upload a new model obj file.
	If the file successfully uploads, point them to the editor.
-->
<body>
<div class="container-fluid text-center"> 
  <div class="row content">
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left"> 


	<?php
		$user_id  = $_COOKIE["user_id"];
		if (isset($user_id)) {
			echo '<h1>Upload a new model</h1><br>';
			echo '<form action="upload-result.php" method="post" enctype="multipart/form-data">';
			echo '<p>Object file: (must be a <code>.obj</code> file)</p>';
			echo '<input type="file" name="fileToUpload" id="fileToUpload"><br><br>';
			echo '<input type="submit" value="Upload OBJ File" name="submit">';

			echo '</form>';
		} else {
			echo 'You must be signed in to upload a model.';
		}
	?>

    </div>

    <div class="col-sm-2 sidenav">

    </div>
  </div>
</div>
	<?php
	   generate_footer();
	?>
</body>

</html>