
<?php
  // Gabriel Pinkard
  echo "<!DOCTYPE html>";
  echo "<html lang='en'>";
  include '../boilerplate.php';
  generate_head('Categories', 'Categories');
  echo "<div class='container-fluid text-left'>";
  echo "<div class='row content'>";
  echo "<div class='col-sm-1 sidenav'>";
  echo "</div>";
  echo "<div class='col-sm-10 text-center'>";
  $db_path = '../../db/modular.db';
  $model_id = $_GET["id"]; // model id
  try {
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $get_Model = $db->prepare("select * from Model natural join Material natural join User where model_id = ? and creator_id = user_id");
    $get_Model->bindParam(1, $model_id); 
    $get_Model->execute();
    $result_set = $get_Model->fetchAll();
    foreach($result_set as $tuple){
      $model_name = $tuple["model_name"]; 
      $creator_name = $tuple["username"];
      $mass_in_grams = $tuple["mass_in_grams"];
      $cost_per_gram = $tuple["cost_per_gram"];
      $cost = $cost_per_gram * $mass_in_grams / 100;
      $material_name = $tuple["material_name"];
      $image = $tuple["image"];
      $model_id = $tuple["model_id"];
      $current_user = $_COOKIE["user_id"];
      $description = $tuple["description"];
      echo "<h2>$model_name</h2><font size='4'> by <a href='../profile/profile.php?username=$creator_name'>$creator_name</a></font>";
      echo "<br>";
      // Picture
      echo "<div class='col-sm-6 '><br><br>";
      echo '<img style="height: 95%; width: 95%" src="' . $image . '">';
      echo "</div>";
      // Stats
      echo "<div class='col-sm-6 text-center'>";
      echo "<br>";
      echo "<br>";
      echo "<font size='3'>";
      echo "<b>Material</b>: <i>$material_name</i>";
      echo "<br>";
      echo "<br>";
      echo "<b>Mass in grams</b>: <i>$mass_in_grams</i>";
      echo "<br>";
      echo "<br>";
      echo "<b>price</b>:<i> $$cost</i>";
      echo "<br>";
      echo "<br>";
      echo "<p><b><i>Description: </i></b>$description</p>";
      echo "</font>";
      if(!isset($current_user)) {
      	echo "<font size='3'>";
      	echo "Please <a href='../login/login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a> to add this to your cart";
      	echo "<font>";
      } else {
      	echo "<br>";
      	echo "<font size='3'>";
      	echo "<form action='addedToCart.php' method='post'";
      	echo "<font size='4' color='282a2e'><b>quantity</b></font>: <input type='number' name='qty' value='1' min='1'/><br>"; 
      	echo "<input type='hidden' name='current_user' value=$current_user>";
      	echo "<input type='hidden' name='model_id' value=$model_id>";
      	echo "<input type='hidden' name='model_name' value=$model_name>";
      	echo "<br>";
      	echo "<input type='submit' value='Add to cart'/>";
      	echo "</form>";
      	echo "<br>";
      	echo "<form action='addedToBookmarks.php' method='post'>";
      	echo "<input type='hidden' name='current_user' value=$current_user>";
      	echo "<input type='hidden' name='model_id' value=$model_id>";
      	echo "<br>";
      	echo "<input type='submit' value='Add to bookmarks'/>";
      	echo "</form>";
      	echo "<br>";
      	echo "<br>";
      	echo "<a href='../review/review.php?id=$model_id'><button>Add review</button></a>";
        echo '<br><br>';
        if ($tuple["creator_id"] == $_COOKIE["user_id"]) {
          echo '<a href="../editor/index.php?modelID=' . $model_id .  '"><button>Edit this model</button></a>';
        }
      	echo "</font>";
      	echo "<br>";
      	echo "<br>";
      }
      echo "</div>";
    }
  } catch(PDOException $e){
      die('Exception : ' . $e->getMessage());
  }
  // reviews
  echo "<br><br><br>";
  echo "<font size='6' color='282a2e'>Reviews</font>"; 
  $db_path = '../../db/modular.db';
  $model_id = $_GET["id"]; // model id
  try {
    $db = new PDO('sqlite:' . $db_path);
    $get_Review = $db->prepare("select * from Review natural join User natural join Model where model_id = ?");
    $get_Review->bindParam(1, $model_id); 
    $get_Review->execute();  
    $result_set = $get_Review->fetchAll();
    echo "<br>";
    echo "<br>";
    foreach($result_set as $tuple){
      $score = $tuple["stars"];
      $user_name = $tuple["username"];
      $model_name = $tuple["model_name"];
      $date = $tuple["review_date"];
      // MAKE SURE TO GET REVIEW TITLE
      $comment = $tuple["comment"];
      echo "<div class='card col-sm-12'>";
      echo "<div class='card-header'><i><a href='../profile/profile.php?username=$user_name'>$user_name</a></i> gave <i>$model_name</i> $score stars";
      echo "<br>";
      echo "$comment";
      echo "<br>";
      echo "Reviewed on $date";
      echo "</div>";
      //echo "<div class='card-body'>$comment</div>";
      //echo "<div class='card-footer'>Reviewed on $date</div>";
      echo "</div>";
    }
    //echo "</div>";
  } catch(PDOException $e){
      die('Exception : ' . $e->getMessage());
  }
  //$db = null // disconnect
  echo "</div>";
  echo "<div class='col-sm-1 sidenav'>";
  echo "</div>";
  $db = null;
?>
