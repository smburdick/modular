
<?php
      // database path
  echo "<!DOCTYPE html>";
  error_reporting(0);
  echo "<html lang='en'>";
  include '../boilerplate.php';
  generate_head('Categories', 'Categories');
  echo "<div class='container-fluid text-center'>";
  echo "<div class='row content'>";
  echo "<div class='col-sm-3 sidenav'>";
  echo "</div>";
  echo "<div class='col-sm-6 text-center'>";
  $db_path = '../../db/modular.db';
  $cat_id = $_GET["id"];
  $cat_name = $_GET["cat_name"];
  echo "<h1>$cat_name</h1>";
  echo "<br>";
  if(!isset($cat_id)) echo "ERROR!";
    try {
      $db = new PDO('sqlite:' . $db_path);
      $get_belongsTo = $db->prepare("select model_name, username, model_id, description from Category natural join BelongsTo natural join Model natural join User where category_id = ? and creator_id = user_id;");
      $get_belongsTo->bindParam(1, $cat_id);
      $get_belongsTo->execute();
      $results = $get_belongsTo->fetchAll(); 
      foreach($results as $tuple){
	$model_name = $tuple["model_name"];
	$user_name = $tuple["username"];
	$model_id = $tuple["model_id"];
	$description = $tuple["description"];
	echo "<div class='card'>";
	echo "<div class='card-header'>";
	echo "<a href='../product/product.php?id=$model_id'><font size='5'>$model_name</font></a> <font size=3>by <i>$user_name</i></font>";
	echo "<br>";
	echo "<br>";
	echo "<i>$description</i>";
	echo "<br>";
	echo "<br>";
	echo "</div>";
	echo "</div>";
	echo "<br>";
	echo "<br>";
      }
    } catch(PDOException $e){
      die('Exception : ' . $e->getMessage());
    }
  echo "<div class='col-sm-3 sidenav'>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  $db = null; // disconnect 
?>
