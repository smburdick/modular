<!DOCTYPE html>
<html lang="en">
<?php
	include '../boilerplate.php';
	generate_head('Modular', '');
	//style="height: auto; overflow: hidden"
	error_reporting(0);
?>
<body>
	<div class="container-fluid text-center">
		<div class="row content">
				<div class="col-sm-1 sidenav">
					
				</div>
				<div class="col-sm-10 text-center"> 
					<center><img src="../../logo/modular_logo.png" style="width: 75%; height: 75%"></center>
					<h2>Welcome to the future of 3-D printing!</h2>
				</div>
				<div class="col-sm-1 sidenav">
					
				</div>
			</div>
			<div class="row content">
				<div class="col-sm-1 sidenav"></div>
				<div class="col-sm-5" align="center">
					 <h3> Featured Categories </h3>
					<?php
					$db = new PDO('sqlite:' . $db_path);
					$get_categories = 'select * from category;';
					$result_set = $db->query($get_categories);
					//loop and print out all the categories
					foreach($result_set as $tuple){
				  $name = $tuple["category_name"];
				  $description = $tuple["category_description"];
				  $categoryID = $tuple["category_id"];
					 		echo "<div class='card'>";
						  echo "<div class='card-header'>";
						  echo "<a href='selected_category.php?id=$categoryID&cat_name=$name'><font size='5'>$name</font></a>";
						  echo "<div class='card-body'>";
						  echo "<i>$tuple[category_description]</i>";
						  echo "</div>";
						  echo "</div>";
						  echo "</div>";
						}
						$db = null;
					 ?>
				</div>
				<div class="col-sm-5" align="center">
				</div>
			</div>
			<div class="col-sm-1 sidenav">
			</div>
	</div>
</body>
</html>