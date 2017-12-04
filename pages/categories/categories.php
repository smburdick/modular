<<<<<<< HEAD
  <?php
    //Gabriel Pinkard
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    include '../boilerplate.php';
    generate_head('Categories', 'Categories');
    echo "<div class='container-fluid text-center'>";
    echo "<div class='row content'>";
    echo "<div class='col-sm-3 sidenav'>";
    echo "</div>";
    echo "<div class='col-sm-6 text-center'>";
    echo "<h1>Categories</h1>";
    echo "<br>";
    $db_path = '../../db/modular.db';
      try {
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
	  echo "<a href='/categories/selected_category.php?id=$categoryID&cat_name=$name'><font size='5'>$name</font></a>";
	  echo "<div class='card-body'>";
	  echo "<i>$tuple[category_description]</i>";
	  echo "</div>";
	  echo "</div>";
	  echo "</div>";
	  echo "<br>";
	}
      } catch(PDOException $e){
	die('Exception : ' . $e->getMessage());
      }
    $db = null; // disconnect 
    echo "<div class='col-sm-3 sidenav'>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  ?>
=======
<!DOCTYPE html>
<html lang="en">
  <?php
    include '../boilerplate.php';
    generate_head('Categories', 'Categories');
  ?>
  <div class="col-sm-2 sidenav">
        </div>
  <h2>Categories</h2>
  <div class="col-sm-8 text-left"> <br><br>
  <?php
	  $db_path = '../../db/modular.db';
	  try {
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
	      echo "<a href='selected_category.php?id=$categoryID'>$name</a>";
	      echo "<div class='card-body'>";
	      echo "<i>$tuple[category_description]</i>";
	      echo "</div>";
	      echo "</div>";
	      echo "</div>";
	      echo "<br>";
	    }
	  } catch(PDOException $e){
	    die('Exception : ' . $e->getMessage());
	  }
	  $db = null // disconnect 
	?>
</div>
	<br>
      <hr>
    </div>
    <div class="col-sm-2 sidenav">
    </div>
  



</body>
</html>
>>>>>>> 90a9db87e627dd5a6f06e54c3ed5dd0d83e73985
