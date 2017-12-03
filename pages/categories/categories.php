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
