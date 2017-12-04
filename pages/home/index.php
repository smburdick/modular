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
					<hr>
					<h3> Featured Models</h3>
					<center><br>
					<?php
					$db_file = '../../db/modular.db';
					$db = new PDO('sqlite:' . $db_file);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						echo "<div class=\"card-deck\">";
							$stmt = $db->prepare("SELECT * FROM Model;");
							$success = $stmt->execute();
							$results = $stmt->fetchAll();
							foreach($results as $tuple) {
							?>
								<div class="card" align="center" style="max-width: 300px; min-width: 300px; width: 300px; margin-bottom: 20px">
								<div class="w-300 hidden-xs-down hidden-md-up"><!-- wrap every 2 on sm--></div>
								<?php
								echo '<img class="card-img-top" src="'.$tuple['image'].'">
								<div class="card-body">';
									
									echo "<h4 class=\"card-title\">   $tuple[model_name]</h4>";

									echo "<a href=\"../product/product.php?id=".$tuple['model_id']."\" class=\"card-link\">View Model</a>";
									echo "</div>";
									?>
							</div>
							<?php
							}
						echo "</div>";
					?>
				</center>
				</div>
				<div class="col-sm-5">
					<hr>
					<h3> Featured Categories</h3>
					<br>
					<?php 
						$db_file = '../../db/modular.db';
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
						  echo "<br>";
						}
						$db = null;
					?>
				</div>
			</div>
			<div class="col-sm-1 sidenav">
			</div>
	</div>
</body>
</html>